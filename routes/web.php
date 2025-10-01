<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StudentController;
use Illuminate\Auth\Events\Login;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

// student
Route::prefix('student')->middleware(['auth', 'userAcces:student' , 'preventBack'])->group(function () {
    Route::get('/index', [StudentController::class, 'index'])->name('student.index');

    Route::get('/category/{category}', [StudentController::class, 'showCategory'])->name('student.category.show');
    Route::get('/category/{category}/topic/{topic}', [StudentController::class, 'showTopic'])->name('student.topic.show');
    Route::get('/category/{category}/quiz/{quiz}', [StudentController::class, 'showQuiz'])->name('student.quiz.show');

    Route::post('/topic/{topic}/comment', [StudentController::class, 'storeTopicComment'])->name('student.topic.comment.store');
    Route::post('/quiz/{quiz}/comment', [StudentController::class, 'storeQuizComment'])->name('student.quiz.comment.store');

    Route::delete('/topic/{topic}/comment/{comment}', [StudentController::class, 'destroyTopicComment'])->name('student.topic.comment.destroy');
    Route::delete('/quiz/{quiz}/comment/{comment}', [StudentController::class, 'destroyQuizComment'])->name('student.quiz.comment.destroy');
});



// teacher
Route::prefix('teacher')->middleware(['auth', 'userAcces:teacher', 'preventBack'])->group(function () {
    Route::get('/index', [TeacherController::class, 'index'])->name('teacher.index');
    Route::get('/subject/{subject}', [TeacherController::class, 'showSubject'])->name('teacher.subject.show');

    Route::get('/category/{category}/{kelas}', [TeacherController::class, 'showCategory'])->name('teacher.category.show');
    Route::get('category/{category}/{kelas}/topic/{topic}', [TeacherController::class, 'showTopic'])->name('teacher.topic.show');
    Route::get('category/{category}/{kelas}/quiz/{quiz}', [TeacherController::class, 'showQuiz'])->name('teacher.quiz.show');

    Route::get('category/{category}/{kelas}/create-data', [TeacherController::class, 'createData'])->name('teacher.category.createData');

    Route::get('category/{category}/{kelas}/create-chapter', [TeacherController::class, 'createChapter'])->name('teacher.category.createChapter');
    Route::post('category/{category}/{kelas}/create-chapter', [TeacherController::class, 'storeChapter'])->name('chapter.store');
    Route::get('category/{category}/{kelas}/create-topic', [TeacherController::class, 'createTopic'])->name('teacher.category.createTopic');
    Route::post('category/{category}/{kelas}/create-topic', [TeacherController::class, 'storeTopic'])->name('topic.store');
    Route::get('category/{category}/{kelas}/create-quiz', [TeacherController::class, 'createQuiz'])->name('teacher.category.createQuiz');
    Route::post('category/{category}/{kelas}/create-quiz', [TeacherController::class, 'storeQuiz'])->name('quiz.store');

    Route::get('category/{category}/{kelas}/chapter/{chapter}/edit-chapter', [TeacherController::class, 'editChapter'])->name('chapter.edit');
    Route::put('category/{category}/{kelas}/chapter/{chapter}', [TeacherController::class, 'updateChapter'])->name('chapter.update');
    Route::get('category/{category}/{kelas}/topic/{topic}/edit-topic', [TeacherController::class, 'editTopic'])->name('topic.edit');
    Route::put('category/{category}/{kelas}/topic/{topic}', [TeacherController::class, 'updateTopic'])->name('topic.update');
    Route::get('category/{category}/{kelas}/quiz/{quiz}/edit-quiz', [TeacherController::class, 'editQuiz'])->name('quiz.edit');
    Route::put('category/{category}/{kelas}/quiz/{quiz}', [TeacherController::class, 'updateQuiz'])->name('quiz.update');

    Route::post('/topic/{topic}/comment', [TeacherController::class, 'storeTopicComment'])->name('topic.comment.store');
    Route::post('/quiz/{quiz}/comment', [TeacherController::class, 'storeQuizComment'])->name('quiz.comment.store');

    Route::delete('category/{category}/{kelas}/chapter/{chapter}', [TeacherController::class, 'destroyChapter'])->name('chapter.destroy');
    Route::delete('category/{category}/{kelas}/topic/{topic}', [TeacherController::class, 'destroyTopic'])->name('topic.destroy');
    Route::delete('category/{category}/{kelas}/quiz/{quiz}', [TeacherController::class, 'destroyQuiz'])->name('quiz.destroy');
    Route::delete('/topic/{topic}/comment/{comment}', [TeacherController::class, 'destroyTopicComment'])->name('topic.comment.destroy');
    Route::delete('/quiz/{quiz}/comment/{comment}', [TeacherController::class, 'destroyQuizComment'])->name('quiz.comment.destroy');
});



// admin
Route::prefix('admin')->middleware(['auth', 'userAcces:admin', 'preventBack'])->group(function () {
    Route::get('/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/data-students', [AdminController::class, 'showStudents'])->name('students.show');
    Route::get('/data-teachers', [AdminController::class, 'showTeachers'])->name('teachers.show');
    Route::get('/data-kelas', [AdminController::class, 'showKelas'])->name('kelas.show');
    Route::get('/program-studi', [AdminController::class, 'showProdi'])->name('prodi.show');
    Route::get('/mapel', [AdminController::class, 'showSubjects'])->name('subjects.show');

    Route::get('/create-student', [AdminController::class, 'createStudent'])->name('student.create');
    Route::post('/create-student', [AdminController::class, 'storeStudent'])->name('student.store');
    Route::get('/create-teacher', [AdminController::class, 'createTeacher'])->name('teacher.create');
    Route::post('/create-teacher', [AdminController::class, 'storeTeacher'])->name('teacher.store');
    Route::get('/create-kelas', [AdminController::class, 'createKelas'])->name('kelas.create');
    Route::post('/create-kelas', [AdminController::class, 'storeKelas'])->name('kelas.store');
    Route::get('/create-prodi', [AdminController::class, 'createProdi'])->name('prodi.create');
    Route::post('/create-prodi', [AdminController::class, 'storeProdi'])->name('prodi.store');
    Route::get('/create-subject', [AdminController::class, 'createSubject'])->name('subject.create');
    Route::post('/create-subject', [AdminController::class, 'storeSubject'])->name('subject.store');

    Route::get('/prodi/{id}/edit-prodi', [AdminController::class, 'editProdi'])->name('prodi.edit');
    Route::put('/prodi/{id}', [AdminController::class, 'updateProdi'])->name('prodi.update');
    Route::get('/kelas/{id}/edit-kelas', [AdminController::class, 'editKelas'])->name('kelas.edit');
    Route::put('/kelas/{id}', [AdminController::class, 'updateKelas'])->name('kelas.update');
    Route::get('/subject/{id}/edit-subject', [AdminController::class, 'editSubject'])->name('subject.edit');
    Route::put('/subject/{id}', [AdminController::class, 'updateSubject'])->name('subject.update');
    Route::get('/student/{id}/edit-student', [AdminController::class, 'editStudent'])->name('student.edit');
    Route::put('/student/{id}', [AdminController::class, 'updateStudent'])->name('student.update');
    Route::get('/teacher/{id}/edit-teacher', [AdminController::class, 'editteacher'])->name('teacher.edit');
    Route::put('/teacher/{id}', [AdminController::class, 'updateTeacher'])->name('teacher.update');

    Route::get('/student/{id}/view-student', [AdminController::class, 'viewStudent'])->name('student.view');
    Route::get('/teacher/{id}/view-teacher', [AdminController::class, 'viewTeacher'])->name('teacher.view');
    Route::get('/prodi/{id}/view-prodi', [AdminController::class, 'viewProdi'])->name('prodi.view');
    Route::get('/kelas/{id}/view-kelas', [AdminController::class, 'viewKelas'])->name('kelas.view');
    Route::get('/subject/{id}/view-subject', [AdminController::class, 'viewSubject'])->name('subject.view');

    Route::delete('/prodi/{id}', [AdminController::class, 'destroyProdi'])->name('prodi.destroy');
    Route::delete('/kelas/{id}', [AdminController::class, 'destroyKelas'])->name('kelas.destroy');
    Route::delete('/subject/{id}', [AdminController::class, 'destroySubject'])->name('subject.destroy');
    Route::delete('/student/{id}', [AdminController::class, 'destroyStudent'])->name('student.destroy');
    Route::delete('/teacher/{id}', [AdminController::class, 'destroyTeacher'])->name('teacher.destroy');

    Route::delete('/admin/{id}', [AdminController::class, 'destroyAdmin'])->name('admin.destroy');
});




// Login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// Register
Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);
