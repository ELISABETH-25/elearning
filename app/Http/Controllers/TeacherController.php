<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Kelas;
use App\Models\Topic;
use App\Models\Quiz;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;
use RealRashid\SweetAlert\Facades\Alert;

class TeacherController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        // get only subjects+kelas that the teacher assign for from pivot teacher_subject_kelas
        $teacherSubjectClasses = $teacher->teacherSubjectClasses()
            ->with(['category', 'kelas'])
            ->get();

        $title = 'Dashboard';
        $section = 'Dashboard';
        return view('teacher.index', compact('teacherSubjectClasses', 'title', 'section'));
    }

    public function showSubject(Subject $subject)
    {
        $categories = $subject->categories;
        $title = 'Teacher Subjects';
        $section = $subject->name;
        return view('teacher.subject', compact('subject', 'categories', 'title', 'section'));
    }

    public function showCategory(Category $category, Kelas $kelas)
    {

        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->first();

        $chapters = $teacherSubjectClass->chapters()
            ->with(['topics' => function ($query) {
                $query->latest(); // sort topics by created_at DESC
            }, 'topics.quiz'])
            ->latest()
            ->get();

        $title = 'Mata Pelajaran';
        $section = $category->name;

        return view('teacher.category', compact('category', 'kelas', 'chapters', 'title', 'section'));
    }



    public function createData(Category $category, Kelas $kelas)
    {
        $title = 'Tambah Data';
        $section = $category->name;
        return view('teacher.createData', compact('category', 'kelas', 'title', 'section'));
    }



    // Chapter/bab
    public function createChapter(Category $category, Kelas $kelas)
    {
        $title = 'Tambah Bab';
        $section = $category->name;
        return view('teacher.createChapter', compact('category', 'kelas', 'title', 'section'));
    }

    public function storeChapter(Request $request, Category $category, Kelas $kelas)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
        ]);

        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        Chapter::create([
            'judul' => $validatedData['judul'],
            'teacher_subject_class_id' => $teacherSubjectClass->id,
        ]);
        Alert::success('Success', 'Berhasil tambah Bab');

        return redirect()->route('teacher.category.show', [
            'category' => $category,
            'kelas' => $kelas,
        ]);
    }

    public function editChapter(Category $category, Kelas $kelas, Chapter $chapter)
    {
        $title = 'Edit Bab';
        $section = $chapter->judul;

        // ensure chapter has teacherSubjectClass relation
        $tsc = $chapter->teacherSubjectClass;
        if (! $tsc) {
            abort(404, 'Chapter has no teacher-subject-class association.');
        }

        // ensure the chapter belongs to the same category & kelas from the route
        if ($tsc->category_id !== $category->id || $tsc->kelas_id !== $kelas->id) {
            abort(404, 'Chapter tidak ditemukan di kategori/kelas ini.');
        }

        // load chapters from teacherSubjectClass
        $chapters = $tsc->chapters()->latest()->get();

        // pass chapters
        $category->setRelation('chapters', $chapters);

        return view('teacher.editChapter', compact('category', 'kelas', 'chapter', 'title', 'section'));
    }

    public function updateChapter(Request $request, Category $category, Kelas $kelas, Chapter $chapter)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
        ]);

        // auto assign user_id & category_id
        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        // only allow update if chapter actually belongs to this teacherSubjectClass
        if ($chapter->teacher_subject_class_id !== $teacherSubjectClass->id) {
            abort(403, 'Anda tidak berhak mengubah Bab ini.');
        }

        $chapter->update($validatedData);

        Alert::success('Success', 'Berhasil Edit Bab');
        return redirect()->route('teacher.category.show', [
            'category' => $category->id,
            'kelas' => $kelas->id,
        ]);
    }

    public function destroyChapter(Category $category, Kelas $kelas, Chapter $chapter)
    {
        // auto assign user_id & category_id
        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        // only allow delete if chapter belongs to this teacherSubjectClass
        if ($chapter->teacher_subject_class_id !== $teacherSubjectClass->id) {
            abort(403, 'Anda tidak berhak menghapus Bab ini.');
        }

        $chapter->delete();
        Alert::success('Success', 'Berhasil Hapus Bab');

        return redirect()->route('teacher.category.show', [
            'category' => $category->id,
            'kelas' => $kelas->id,
        ]);
    }




    // Topic
    public function showTopic(Category $category, Kelas $kelas, Topic $topic)
    {
        $title = 'Topik Materi';
        $section = $topic->judul;
        $quiz = $topic->quiz;

        // make sure the topic belongs to the right teacher_subject_class
        $tsc = $topic->teacherSubjectClass;
        if (! $tsc || $tsc->category_id !== $category->id || $tsc->kelas_id !== $kelas->id) {
            abort(404, 'Topik tidak ditemukan di kategori/kelas ini.');
        }

        $topic->load(['comments' => function ($query) use ($topic) {
            $query->where('teacher_subject_class_id', $topic->teacher_subject_class_id)
                ->with(['user', 'replies.user']);
        }]);


        return view('teacher.topic', compact('category', 'kelas', 'topic', 'quiz', 'title', 'section'));
    }

    public function createTopic(Category $category, Kelas $kelas)
    {
        $title = 'Tambah Materi';
        $section = $category->name;

        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        // only chapters that belong to this teacherSubjectClass
        $chapters = $teacherSubjectClass->chapters()->latest()->get();

        return view('teacher.createTopic', compact('category', 'kelas', 'title', 'section', 'chapters'));
    }

    public function storeTopic(Request $request, Category $category, Kelas $kelas)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'body' => 'required',
            'deadline' => 'required|date',
            'chapter_id' => 'required', //pass the chapters inside the form
        ]);

        // auto assign user_id
        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        $validatedData['teacher_subject_class_id'] = $teacherSubjectClass->id;

        Topic::create($validatedData);

        Alert::success('Success', 'Berhasil tambah Materi');
        return redirect()->route('teacher.category.show', [
            'category' => $category->id,
            'kelas'    => $kelas->id,
        ]);
    }

    // edit-update route
    public function editTopic(Category $category, Kelas $kelas, Topic $topic)
    {
        $title = 'Edit Materi';
        $section = $topic->judul;

        // ensure topic belongs to this category & kelas through teacherSubjectClass
        $tsc = $topic->teacherSubjectClass;
        if (! $tsc || $tsc->category_id !== $category->id || $tsc->kelas_id !== $kelas->id) {
            abort(404, 'Materi tidak ditemukan di kategori/kelas ini.');
        }

        $chapters = $tsc->chapters()->latest()->get();

        return view('teacher.editTopic', compact('category', 'kelas', 'topic', 'chapters', 'title', 'section'));
    }

    public function updateTopic(Request $request, Category $category, Kelas $kelas, Topic $topic)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'body' => 'required',
            'deadline' => 'required|date',
            'chapter_id' => 'required|exists:chapters,id', //pass the chapters inside the form
        ]);

        // auto assign user_id
        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        // ensure topic really belongs to this teacherSubjectClass
        if ($topic->teacher_subject_class_id !== $teacherSubjectClass->id) {
            abort(403, 'Anda tidak berhak mengubah Materi ini.');
        }

        $validatedData['teacher_subject_class_id'] = $teacherSubjectClass->id;

        $topic->update($validatedData);

        Alert::success('Success', 'Berhasil Edit Materi');
        return redirect()->route('teacher.topic.show', [
            'category' => $category->id,
            'kelas'    => $kelas->id,
            'topic'    => $topic->id,
        ]);
    }

    // delete
    public function destroyTopic(Category $category, Kelas $kelas, Topic $topic)
    {
        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        if ($topic->teacher_subject_class_id !== $teacherSubjectClass->id) {
            abort(403, 'Anda tidak berhak menghapus Materi ini.');
        }

        $topic->delete();

        Alert::success('Success', 'Berhasil Hapus Materi');
        return redirect()->route('teacher.category.show', [
            'category' => $category->id,
            'kelas'    => $kelas->id,
        ]);
    }






    // Quiz
    public function showQuiz(Category $category, Kelas $kelas, Quiz $quiz)
    {
        $title = 'Quiz';
        $section = $quiz->judul;

        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        if ($quiz->teacher_subject_class_id !== $teacherSubjectClass->id) {
            abort(403, 'Unauthorized to view this quiz');
        }

        $quiz->load(['comments' => function ($query) use ($quiz) {
            $query->where('teacher_subject_class_id', $quiz->teacher_subject_class_id)
                ->with(['user', 'replies.user']);
        }]);


        return view('teacher.quiz', compact('category', 'kelas', 'quiz', 'title', 'section'));
    }

    public function createQuiz(Category $category, Kelas $kelas)
    {
        $title = 'Tambah Quiz';
        $section = $category->name;

        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        // only chapters (and topics) under this TSC
        $chapters = $teacherSubjectClass->chapters()
            ->with('topics.quiz')
            ->latest()
            ->get();

        return view('teacher.createQuiz', compact('category', 'kelas', 'title', 'section', 'chapters'));
    }

    public function storeQuiz(Request $request, Category $category, Kelas $kelas)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'body' => 'required',
            'deadline' => 'required|date',
            'topic_id' => 'required|exists:topics,id', // ensure if topics exist
        ]);

        // auto assign user_id
        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        $validatedData['teacher_subject_class_id'] = $teacherSubjectClass->id;

        Quiz::create($validatedData);

        Alert::success('Success', 'Berhasil tambah Quiz');
        return redirect()->route('teacher.category.show', [
            'category' => $category->id,
            'kelas'    => $kelas->id,
        ]);
    }

    public function editQuiz(Category $category, Kelas $kelas, Quiz $quiz)
    {
        $title = 'Edit quiz';
        $section = $quiz->judul;

        $tsc = $quiz->teacherSubjectClass;
        if (! $tsc || $tsc->category_id !== $category->id || $tsc->kelas_id !== $kelas->id) {
            abort(404, 'Quiz tidak ditemukan di kategori/kelas ini.');
        }

        $chapters = $tsc->chapters()->with('topics.quiz')->get();

        return view('teacher.editQuiz', compact('category', 'kelas', 'quiz', 'chapters', 'title', 'section'));
    }

    public function updateQuiz(Request $request, Category $category, Kelas $kelas, Quiz $quiz)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'body' => 'required',
            'deadline' => 'required|date',
            'topic_id' => [
                'required',
                'exists:topics,id',
                (new Unique('quizzes', 'topic_id'))->ignore($quiz->id),
            ], // ensure if topics exist
        ]);

        // auto assign user_id
        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        if ($quiz->teacher_subject_class_id !== $teacherSubjectClass->id) {
            abort(403, 'Anda tidak berhak mengubah quiz ini.');
        }

        $validatedData['teacher_subject_class_id'] = $teacherSubjectClass->id;

        $quiz->update($validatedData);

        Alert::success('Success', 'Berhasil update Quiz');
        return redirect()->route('teacher.quiz.show', [
            'category' => $category->id,
            'kelas'    => $kelas->id,
            'quiz'    => $quiz->id,
        ]);
    }

    public function destroyQuiz(Category $category, Kelas $kelas, Quiz $quiz)
    {
        $teacher = auth()->user()->teacher;
        $teacherSubjectClass = $teacher->teacherSubjectClasses()
            ->where('category_id', $category->id)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        if ($quiz->teacher_subject_class_id !== $teacherSubjectClass->id) {
            abort(403, 'Anda tidak berhak menghapus quiz ini.');
        }

        $quiz->delete();

        Alert::success('Success', 'Berhasil Hapus Quiz');
        return redirect()->route('teacher.category.show', [
            'category' => $category->id,
            'kelas'    => $kelas->id,
        ]);
    }





    // comment-reply
    public function storeTopicComment(Request $request, Topic $topic)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

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

    // comment-reply
    public function storeQuizComment(Request $request, Quiz $quiz)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        // create comment
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
        // check if comment belongs to the topic
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
