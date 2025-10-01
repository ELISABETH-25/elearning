<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\Quiz;
use App\Models\Comment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;


class StudentController extends Controller
{
    public function index()
    {
        // get the authenticated user (student)
        $student = auth()->user()->student;
        $kelas = $student->kelas;

        // load category(subject) that belongs to the student's class
        $categories = $kelas->categoriesDirect()
            ->with([
                'teacherSubjectClasses' => function ($q) use ($kelas) {
                    $q->where('kelas_id', $kelas->id)
                        ->with([
                            'teacher.user',
                            'chapters.topics.quiz' // 👈 load chapters only through TSC
                        ]);
                }
            ])
            ->get()
            // filter to only display category yg punya sudah punya guru
            ->filter(function ($category) {
                return $category->teacherSubjectClasses->isNotEmpty();
            });

        // get only 5 latest quiz by deadline
        $latestQuizzes = collect();

        foreach ($categories as $category) {
            foreach ($category->teacherSubjectClasses as $tsc) {
                foreach ($tsc->chapters as $chapter) {
                    foreach ($chapter->topics as $topic) {
                        if ($topic->quiz) {
                            $latestQuizzes->push([
                                'quiz' => $topic->quiz,
                                'category' => $category,
                            ]);
                        }
                    }
                }
            }
        }

        $latestQuizzes = $latestQuizzes
            ->sortByDesc(fn($item) => $item['quiz']->deadline)
            ->take(5);


        $title = 'Dashboard';
        $prodi = optional($kelas->prodi)->name ?? null;

        return view('student.index', compact('title', 'kelas', 'prodi', 'categories', 'latestQuizzes'));
    }

    public function showCategory(Category $category)
    {
        $title = 'Mata Pelajaran';
        $student = auth()->user()->student;
        $kelas = $student->kelas;

        $belongs = $kelas->categoriesDirect()->where('categories.id', $category->id)->exists();
        if (! $belongs) {
            abort(403, 'Not Allowed');
        }

        // find the teacher_subject_class for this class + category
        $tsc = $category->teacherSubjectClasses()
            ->where('kelas_id', $kelas->id)
            ->first();

        if (! $tsc) {
            abort(404, 'Subject not assigned to this class');
        }

        // only get chapters for this TSC
        $chapters = $tsc->chapters()
            ->with([
                'topics' => function ($query) {
                    $query->latest();
                },
                'topics.quiz'
            ])
            ->latest()
            ->get();

        return view('student.category', compact('category', 'kelas', 'title', 'chapters'));
    }



    // Topic
    public function showTopic(Category $category, Topic $topic)
    {
        $title = 'Materi';
        $section = $category->name;
        $student = auth()->user()->student;
        $kelas = $student->kelas;

        if (! $kelas->categoriesDirect()->where('categories.id', $category->id)->exists()) {
            abort(403);
        }

        // ensure topic belongs to chapter, belongs to teacher_subject_class -> category
        if ($topic->chapter->teacherSubjectClass->category_id !== $category->id) {
            abort(404, 'Topic not found in this category');
        }


        // load comments only for the same teacher_subject_class
        $topic->load(['comments' => function ($query) use ($topic) {
            $query->where('teacher_subject_class_id', $topic->teacher_subject_class_id)
                ->with(['user', 'replies.user']);
        }]);

        return view('student.topic', compact('category', 'kelas', 'topic', 'title', 'section'));
    }

    // comment-reply
    public function storeTopicComment(Request $request, Topic $topic)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        // get auth student
        $student = auth()->user()->student;
        $kelas = $student->kelas;

        // get the category id from pivot teacher_subject_class
        $teacherTsc = $topic->chapter->teacherSubjectClass ?? null;

        if (! $teacherTsc) {
            abort(403, 'Invalid topic structure');
        }

        $categoryId = $teacherTsc->category_id;

        // same check as showTopic: ensure kelas has access to this category via pivot category_kelas
        if (! $kelas->categoriesDirect()->where('categories.id', $categoryId)->exists()) {
            abort(403, 'Not Allowed, this class does not have this subject');
        }

        // extra safety ensure if the topic belong to the right teacher using teacher_subject_class pivot
        if ($topic->teacher_subject_class_id !== $teacherTsc->id) {
            abort(404, 'Invalid topic for this subject');
        }

        // if parent_id supplied, ensure parent is a comment for this topic
        if ($request->parent_id) {
            $parent = Comment::find($request->parent_id);
            if (! $parent || $parent->topic_id !== $topic->id) {
                abort(404, 'Invalid parent comment');
            }
        }

        // create comment
        $topic->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'teacher_subject_class_id' => $topic->teacher_subject_class_id,
        ]);

        Alert::success('Success', 'Berhasil tambah komentar');
        return back();
    }



    // delete
    public function destroyTopicComment(Topic $topic, Comment $comment)
    {
        // check if comment belongs to the topic
        if ($comment->topic_id !== $topic->id) {
            abort(404);
        }

        // only owner can delete
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        Alert::success('Success', "Komentar berhasil dihapus");
        return back();
    }





    // Quiz
    public function showQuiz(Category $category, Quiz $quiz)
    {
        $title = 'Quiz';
        $section = $category->name;
        $student = auth()->user()->student;
        $kelas = $student->kelas;

        // ensure quiz belongs to the class through teacherSubjectClass -> category
        if (! $kelas->categoriesDirect()
            ->where('categories.id', $quiz->teacherSubjectClass->category_id)
            ->exists()) {
            abort(403, 'Not Allowed');
        }

        $quiz->load([
            'topic',
            'teacherSubjectClass.teacher.user',
            'comments' => function ($query) use ($quiz) {
                $query->where('teacher_subject_class_id', $quiz->teacher_subject_class_id)
                    ->with(['user', 'replies.user']);
            },
        ]);

        return view('student.quiz', compact('category', 'quiz', 'kelas', 'title', 'section'));
    }


    public function storeQuizComment(Request $request, Quiz $quiz)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        // get auth student
        $student = auth()->user()->student;
        $kelas = $student->kelas;

        // ensure this student's kelas has access to quiz's category
        $teacherTsc = $quiz->topic->chapter->teacherSubjectClass ?? null;

        if (! $teacherTsc) {
            abort(403, 'Invalid topic structure');
        }

        $categoryId = $teacherTsc->category_id;

        // same check as showTopic: ensure kelas has access to this category via pivot category_kelas
        if (! $kelas->categoriesDirect()->where('categories.id', $categoryId)->exists()) {
            abort(403, 'Not Allowed, this class does not have this subject');
        }

        // if parent_id supplied, ensure parent is a comment for this quiz
        if ($request->parent_id) {
            $parent = Comment::find($request->parent_id);
            if (! $parent || $parent->quiz_id !== $quiz->id) {
                abort(404, 'Invalid parent comment');
            }
        }

        $quiz->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'teacher_subject_class_id' => $quiz->teacher_subject_class_id,
        ]);

        Alert::success('Success', 'Berhasil tambah komentar');
        return back();
    }

    // delete
    public function destroyQuizComment(Quiz $quiz, Comment $comment)
    {
        // sanity check: comment belongs to this quiz
        if ($comment->quiz_id !== $quiz->id) {
            abort(404);
        }

        // only owner can delete
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        Alert::success('Success', "Komentar berhasil dihapus");
        return back();
    }
}
