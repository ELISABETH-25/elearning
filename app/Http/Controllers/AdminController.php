<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Kelas;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $admins = User::where('role', 'admin')->get();

        return view('admin.index', compact('title', 'admins'))->with([
            'teacherTotal' => Teacher::count(),
            'studentTotal' => Student::count(),
            'prodiTotal' => Prodi::count(),
            'kelasTotal' => Kelas::count(),
            'subjectTotal' => Category::count(),
        ]);
    }

    // delete admin
    public function destroyAdmin($id)
    {
        // find the user
        $admin = User::where('role', 'admin')->findOrFail($id);

        // prevent deleting the last admin (optional safeguard)
        $adminCount = User::where('role', 'admin')->count();
        if ($adminCount <= 1) {
            Alert::error('Error', 'Tidak bisa menghapus admin terakhir.');
            return redirect()->back()->with('error', 'Tidak bisa menghapus admin terakhir.');
        }

        // delete the admin
        $admin->delete();

        Alert::success('Success', 'Berhasil delete admin');
        return redirect()->back()->with('success', 'Admin berhasil dihapus.');
    }

    // Prodi
    public function showProdi()
    {
        $title = 'Program Studi';
        $section = 'Prodi';

        $total = Prodi::count();

        $prodis = Prodi::withCount(['kelas', 'students'])->get();

        return view('admin.dataProdi', compact('title', 'section', 'prodis', 'total'));
    }

    public function viewProdi($id)
    {
        $title = 'Detail Program Studi';
        $section = 'Prodi';
        $prodis = Prodi::withCount(['kelas', 'students'])->findOrFail($id);
        return view('admin.viewProdi', compact('title', 'section', 'prodis'));
    }

    // create-store
    public function createProdi()
    {
        $title = 'Tambah Program Studi';
        $section = 'Prodi';
        return view('admin.createProdi', compact('title', 'section'));
    }

    public function storeProdi(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kode' => 'required|string|max:6',
        ]);

        // auto assign user_id
        $validated['user_id'] = auth()->user()->id;

        $prodi = Prodi::create($validated);

        Alert::success('Success', 'Berhasil tambah Prodi');
        return redirect()->route('prodi.view', $prodi->id);
    }

    // edit-update
    public function editProdi($id)
    {
        $title = 'Edit Prodi';
        $section = 'Prodi';
        $prodi = Prodi::findOrFail($id);
        return view('admin.editProdi', compact('title', 'section', 'prodi'));
    }

    public function updateProdi(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kode' => 'required|string|max:6',
        ]);

        $prodi = Prodi::findOrFail($id);
        $prodi->update($request->all());

        Alert::success('Success', 'Berhasil Edit Prodi');
        return redirect()->route('prodi.view', $prodi->id);
    }

    // delete
    public function destroyProdi($id)
    {
        $prodi = Prodi::findOrFail($id);
        $prodi->delete();
        Alert::success('Success', 'Berhasil Hapus Prodi');
        return redirect()->route('prodi.show');
    }








    // Kelas
    public function showKelas()
    {
        $title = 'Data Kelas';
        $section = 'Kelas';

        $total = Kelas::count();

        $kelas = Kelas::withCount('students', 'categoriesDirect')
            ->with('prodi', 'categoriesDirect')
            ->get();

        return view('admin.dataKelas', compact('title', 'section', 'kelas', 'total'));
    }

    public function viewKelas($id)
    {
        $title = 'View Kelas';
        $section = 'Kelas';

        $total = Kelas::count();

        $kelas = Kelas::withCount('students', 'categoriesDirect')
            ->with('prodi', 'categoriesDirect')->findOrFail($id);

        return view('admin.viewKelas', compact('title', 'section', 'kelas', 'total'));
    }

    // create -store
    public function createKelas()
    {
        $title = 'Tambah Kelas';
        $section = 'Kelas';
        $prodis = Prodi::all();
        return view('admin.createKelas', compact('title', 'section', 'prodis'));
    }

    public function storeKelas(Request $request)
    {
        $validated = $request->validate([
            'tingkat' => 'required|string|max:3',
            'name' => 'required|string|max:255',
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        $kelas = Kelas::create($validated);

        Alert::success('Success', 'Berhasil tambah Kelas');
        return redirect()->route('kelas.view', $kelas->id);
    }

    // edit - update
    public function editKelas($id)
    {
        $title = 'Edit Kelas';
        $section = 'Kelas';
        $kelas = Kelas::findOrFail($id);
        $prodis = Prodi::all();

        return view('admin.editKelas', compact('title', 'section', 'kelas', 'prodis'));
    }

    public function updateKelas(Request $request, $id)
    {
        $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'prodi_id' => 'required|exists:prodis,id',
            'name' => 'required|string|max:255',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        Alert::success('Success', 'Berhasil Edit Kelas');
        return redirect()->route('kelas.view', $kelas->id);
    }

    // delete
    public function destroyKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        Alert::success('Success', 'Berhasil Hapus Kelas');
        return redirect()->route('kelas.show');
    }








    // Subject
    public function showSubjects()
    {
        $title = 'Mata Pelajaran';
        $section = 'Mata Pelajaran';

        $total = Category::count();

        // load teachers and kelasDirect
        $subjects = Category::withCount('teachers', 'kelasDirect')
            ->with(['teachers', 'kelasDirect'])
            ->get();

        return view('admin.dataSubject', compact('title', 'section', 'total', 'subjects'));
    }

    public function viewSubject($id)
    {
        $title = 'View Mata Pelajaran';
        $section = 'Mata Pelajaran';

        $total = Category::count();

        // load teachers and kelasDirect
        $subject = Category::withCount('teachers', 'kelasDirect')
            ->with([
                // 'teachers',
                'kelasDirect.prodi',
                'teacherSubjectClasses.teacher',
                'teacherSubjectClasses.kelas',
            ])->findOrFail($id);

        return view('admin.viewSubject', compact('title', 'section', 'total', 'subject'));
    }

    // create
    public function createSubject()
    {
        $title = 'Tambah Mata Pelajaran';
        $section = 'Mata Pelajaran';
        // $kelas = Kelas::all();
        $kelas = Kelas::with('prodi')->orderBy('name', 'asc')->get();
        return view('admin.createSubject', compact('title', 'section', 'kelas'));
    }

    public function storeSubject(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kelas_id' => 'array',
            'kelas_id.*' => 'exists:kelas,id',
        ]);

        // pisahkan kelas_id
        $kelasIds = $validated['kelas_id'] ?? [];

        // data untuk category saja
        $categoryData = [
            'name' => $validated['name'],
            'user_id' => auth()->user()->id,
        ];

        // Category::create($validated);
        $category = Category::create($categoryData);

        if (!empty($kelasIds)) {
            $category->kelasDirect()->attach($kelasIds);
        }

        Alert::success('Success', 'Berhasil Tambah Mata Pelajaran');
        // dd($category->kelasDirect);
        return redirect()->route('subject.view', $category->id);
    }

    // edit-update
    public function editSubject($id)
    {
        $title = 'Edit Mata Pelajaran';
        $section = 'Mata Pelajaran';
        $subject = Category::with('kelasDirect')->findOrFail($id);
        // $kelas = Kelas::all();
        $kelas = Kelas::with('prodi')->orderBy('name', 'asc')->get();
        return view('admin.editSubject', compact('title', 'section', 'subject', 'kelas'));
    }

    public function updateSubject(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kelas_id' => 'array',
            'kelas_id.*' => 'exists:kelas,id',
        ]);

        // pisahkan kelas_id
        $kelasIds = $validated['kelas_id'] ?? [];

        // ambil hanya data untuk category
        $categoryData = [
            'name' => $validated['name'],
        ];

        $subject = Category::findOrFail($id);

        // update category
        $subject->update($categoryData);

        // sync pivot category_kelas
        $subject->kelasDirect()->sync($kelasIds);


        Alert::success('Success', 'Berhasil Edit Mata Pelajaran');
        return redirect()->route('subject.view', $subject->id);
    }

    // delete
    public function destroySubject($id)
    {
        $subject = Category::findOrFail($id);
        $subject->delete();
        Alert::success('Success', 'Berhasil Hapus Mata Pelajaran');
        return redirect()->route('subjects.show');
    }






    // Student
    public function showStudents()
    {
        $title = 'Data Siswa';
        $section = 'Siswa';

        // get total students
        $total = Student::count();

        // load student with kelas
        $students = Student::with(['user', 'kelas'])->get();

        return view('admin.dataStudent', compact('title', 'section', 'students', 'total'));
    }

    // view detail student
    public function viewStudent($id)
    {
        $title = 'Detail Siswa';
        $section = 'Siswa';
        $student = Student::with(['user', 'kelas'])->findOrFail($id);
        return view('admin.viewStudent', compact('title', 'section', 'student'));
    }

    // create - store
    public function createStudent()
    {
        $title = 'Tambah Siswa';
        $section = 'Siswa';
        $kelas = Kelas::all();

        return view('admin.createStudent', compact('title', 'section', 'kelas'));
    }

    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            // user fields
            'name' => 'required|string|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|string|min:5',

            // student field
            'kelas_id' => 'required|exists:kelas,id',
            'nis' => 'required|string|max:10|unique:students,nis',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date',
            'domisili' => 'required|string|max:255',
            'phone' => 'required|string|max:12|regex:/^\d{8,12}$/',
            'alamat' => 'required|string|max:255',
            'wali' => 'required|string|max:255',
            'angkatan' => 'required|date',
            'agama' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1048',
        ], [
            'phone.regex' => 'Nomor HP harus terdiri dari 12 angka tanpa spasi',
        ]);

        DB::beginTransaction();
        try {
            $password = $request->filled('password') ? $request->password : '12345';
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'student',
            ]);

            // file upload
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('user-foto', 'public');
            }

            Student::create([
                'user_id' => $user->id,
                'kelas_id' => $validated['kelas_id'],
                'nis' => $validated['nis'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'domisili' => $validated['domisili'],
                'phone' => $validated['phone'],
                'alamat' => $validated['alamat'],
                'wali' => $validated['wali'],
                'angkatan' => $validated['angkatan'],
                'agama' => $validated['agama'],
                'foto' => $fotoPath,
            ]);

            DB::commit();

            Alert::success('Success', 'Berhasil Tambah Siswa');

            // get latest created student
            $student = Student::where('user_id', $user->id)->first();
            return redirect()->route('student.view', $student->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()
                ->withInput()
                ->withErrors('general', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }

    // edit-update
    public function editStudent($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $kelas = Kelas::all();
        $section = 'Siswa';
        $title = 'Edit Siswa';

        return view('admin.editStudent', compact('title', 'section', 'student', 'kelas'));
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $validated = $request->validate([
            // user fields
            'name' => 'required|string|max:255',
            'email' => ['required', 'email:dns', Rule::unique('users', 'email')->ignore($student->user->id)],
            'password' => 'nullable|string|min:5',

            // student fields
            'kelas_id' => 'required|exists:kelas,id',
            'nis' => ['required', 'string', 'max:10', Rule::unique('students', 'nis')->ignore($student->id)],
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date',
            'domisili' => 'required|string|max:255',
            'phone' => 'required|string|max:12|regex:/^\d{8,12}$/',
            'alamat' => 'required|string|max:255',
            'wali' => 'required|string|max:255',
            'angkatan' => 'required|date',
            'agama' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1048',
        ], [
            'phone.regex' => 'Nomor HP harus terdiri dari 12 angka tanpa spasi',
        ]);

        DB::beginTransaction();
        try {
            // update user
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $request->filled('password') ? $validated['password'] : $student->user->password, //keep old pass if not fill new one
            ]);

            // file upload
            $fotoPath = $student->foto;

            // check if old photo exist
            if ($request->hasFile('foto')) {
                // delete old foto
                if ($request->oldFoto) {
                    Storage::disk('public')->delete($request->oldFoto);
                }
                // new file
                $fotoPath = $request->file('foto')->store('user-foto', 'public');
            }

            // update student
            $student->update([
                'kelas_id' => $validated['kelas_id'],
                'nis' => $validated['nis'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'domisili' => $validated['domisili'],
                'phone' => $validated['phone'],
                'alamat' => $validated['alamat'],
                'wali' => $validated['wali'],
                'angkatan' => $validated['angkatan'],
                'agama' => $validated['agama'],
                'foto' => $fotoPath,
            ]);

            DB::commit();
            Alert::success('Success', 'Berhasil Edit Siswa');
            return redirect()->route('student.view', $student->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()
                ->withInput()
                ->withErrors('general', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }

    // delete
    public function destroyStudent($id)
    {
        DB::beginTransaction();
        try {
            $student = Student::with('user')->findOrFail($id);

            if ($student->foto) {
                Storage::disk('public')->delete($student->foto);
            }

            $student->user->delete();

            // $student->delete();
            DB::commit();
            Alert::success('Success', 'Berhasil Hapus Siswa');
            return redirect()->route('students.show');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()
                ->withInput()
                ->withErrors('general', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }







    // Teacher
    public function showTeachers()
    {
        $title = 'Data Guru';
        $section = 'Guru';

        // get total teachers
        $total = Teacher::count();

        // eager load teacher with user + relation subject + kelas
        $teachers = Teacher::with([
            'user',
            'teacherSubjectClasses.category',
            'teacherSubjectClasses.kelas'
        ])
            ->withCount(['categories as category_count'])
            ->get();

        return view('admin.dataTeacher', compact('title', 'section', 'teachers', 'total'));
    }

    // view detail teacher
    public function viewTeacher($id)
    {
        $title = 'Detail Guru';
        $section = 'Guru';
        $teacher = Teacher::with([
            'user',
            'teacherSubjectClasses.category',
            'teacherSubjectClasses.kelas'
        ])->findOrFail($id);

        return view('admin.viewTeacher', compact('title', 'section', 'teacher'));
    }

    // create
    public function createTeacher()
    {
        $title = 'Tambah Guru';
        $section = 'Guru';

        // $categories = Category::orderBy('name')->get();
        $categories = Category::with('kelasDirect')->orderBy('name')->get();

        // get all taken assignments
        $takenAssignments = DB::table('teacher_subject_class')
            ->select(DB::raw("CONCAT(category_id,'|',kelas_id) as pair"))
            ->pluck('pair')
            ->toArray();

        return view('admin.createTeacher', compact('title', 'section', 'categories', 'takenAssignments'));
    }

    public function storeTeacher(Request $request)
    {
        $validated = $request->validate([
            // user field
            'name' => 'required|string|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|string|min:5',

            // teacher field
            'nip' => 'required|string|max:18|unique:teachers,nip',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date',
            'domisili' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^\d{8,12}$/'],
            'alamat' => 'required|string|max:255',
            'tahun_masuk' => 'required|date',
            'agama' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1048',

            // assignments: array of 'categoryId|KelasId'
            'assignments' => 'nullable|array',
            'assignments.*' => ['regex:/^\d+\|\d+$/'],
        ], [
            'phone.regex' => 'Nomor HP harus terdiri dari 12 angka tanpa spasi',
            'assignments.*.regex' => 'Format assignment invalid',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'teacher',
            ]);

            // file upload
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('user-foto', 'public');
            }

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'domisili' => $validated['domisili'],
                'jabatan' => $validated['jabatan'],
                'phone' => $validated['phone'],
                'alamat' => $validated['alamat'],
                'tahun_masuk' => $validated['tahun_masuk'],
                'agama' => $validated['agama'],
                'foto' => $fotoPath,
            ]);

            // insert assignment to teacher_subject_class pivot table (only if valid)
            if (!empty($validated['assignments'])) {
                $now = now();
                $rows = [];

                foreach ($validated['assignments'] as $pair) {
                    [$categoryId, $kelasId] = explode('|', $pair);

                    // ensure the pair exists in category_kelas (create if missing)
                    $exists = DB::table('category_kelas')
                        ->where('category_id', $categoryId)
                        ->where('kelas_id', $kelasId)
                        ->exists();

                    if (! $exists) {
                        DB::table('category_kelas')->insert([
                            'category_id' => $categoryId,
                            'kelas_id' => $kelasId,
                        ]);
                    }

                    // avoid duplicate by check teacher_subject_class / ensure this subject-class is not already taken by another teacher
                    $already = DB::table('teacher_subject_class')
                        ->where('category_id', $categoryId)
                        ->where('kelas_id', $kelasId)
                        ->exists();

                    if ($already) {
                        continue;
                    }

                    $rows[] = [
                        'teacher_id' => $teacher->id,
                        'category_id' => $categoryId,
                        'kelas_id' => $kelasId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if (!empty($rows)) {
                    // insert in bulk
                    DB::table('teacher_subject_class')->insert($rows);
                }
            }

            DB::commit();

            Alert::success('Success', 'Berhasil tambah Guru');

            // get latest created teacher
            $teacher = Teacher::where('user_id', $user->id)->first();
            return redirect()->route('teacher.view', $teacher->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            dd($e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['general', 'Terjadi kesalahan, silahkan coba lagi']);
        }
    }

    // edit - update
    public function editTeacher($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        $title = 'Edit Guru';
        $section = 'Guru';

        // $categories = Category::orderBy('name')->get();
        $categories = Category::with('kelasDirect')->orderBy('name')->get();

        // get old assignments
        $existingAssignments = DB::table('teacher_subject_class')
            ->where('teacher_id', $teacher->id)
            ->pluck(DB::raw("CONCAT(category_id,'|',kelas_id)"))
            ->toArray();

        // collect all taken assignments (by ANY teacher)
        $takenAssignments = DB::table('teacher_subject_class')
            ->where('teacher_id', '<>', $teacher->id) // exclude current teacher
            ->selectRaw("CONCAT(category_id,'|',kelas_id) as pair")
            ->pluck('pair')
            ->toArray();

        return view('admin.editTeacher', compact('title', 'section', 'categories', 'teacher', 'existingAssignments', 'takenAssignments'));
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);

        $validated = $request->validate([
            // user fields
            'name' => 'required|string|max:255',
            'email' => ['required', 'email:dns', Rule::unique('users', 'email')->ignore($teacher->user->id)],
            'password' => 'nullable|string|min:5',

            // teacher fields
            'nip' => ['required', 'string', 'max:18', Rule::unique('teachers', 'nip')->ignore($teacher->id)],
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date',
            'domisili' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^\d{8,12}$/'],
            'alamat' => 'required|string|max:255',
            'tahun_masuk' => 'required|date',
            'agama' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1048',

            // assignments
            'assignments' => 'nullable|array',
            'assignments.*' => ['regex:/^\d+\|\d+$/'],
        ]);

        DB::beginTransaction();
        try {
            // update user
            $teacher->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $request->filled('password') ? $validated['password'] : $teacher->user->password,
            ]);

            // file upload
            $fotoPath = $teacher->foto;

            // check if old photo exist
            if ($request->hasFile('foto')) {
                // delete old foto
                if ($request->oldFoto) {
                    Storage::disk('public')->delete($request->oldFoto);
                }
                // new file
                $fotoPath = $request->file('foto')->store('user-foto', 'public');
            }

            // update teacher
            $teacher->update([
                'nip' => $validated['nip'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'domisili' => $validated['domisili'],
                'jabatan' => $validated['jabatan'],
                'phone' => $validated['phone'],
                'alamat' => $validated['alamat'],
                'tahun_masuk' => $validated['tahun_masuk'],
                'agama' => $validated['agama'],
                'foto' => $fotoPath,
            ]);

            // update assignments
            DB::table('teacher_subject_class')->where('teacher_id', $teacher->id)->delete();

            if (!empty($validated['assignments'])) {
                $now = now();
                $rows = [];

                foreach ($validated['assignments'] as $pair) {
                    [$categoryId, $kelasId] = explode('|', $pair);

                    // only insert into category_kelas if not exists
                    $exists = DB::table('category_kelas')
                        ->where('category_id', $categoryId)
                        ->where('kelas_id', $kelasId)
                        ->exists();

                    if (! $exists) {
                        DB::table('category_kelas')->insert([
                            'category_id' => $categoryId,
                            'kelas_id' => $kelasId,
                        ]);
                    }

                    // avoid duplicate by check teacher_subject_class / ensure this subject-class is not already taken by another teacher
                    $already = DB::table('teacher_subject_class')
                        ->where('teacher_id', '<>', $teacher->id)
                        ->where('category_id', $categoryId)
                        ->where('kelas_id', $kelasId)
                        ->exists();

                    if ($already) {
                        continue;
                    }

                    $rows[] = [
                        'teacher_id' => $teacher->id,
                        'category_id' => $categoryId,
                        'kelas_id' => $kelasId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if (!empty($rows)) {
                    DB::table('teacher_subject_class')->insert($rows);
                }
            }

            DB::commit();

            Alert::success('Success', 'Berhasil Edit Guru');
            return redirect()->route('teacher.view', $teacher->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()
                ->withInput()
                ->withErrors(['general' => 'Terjadi kesalahan, silahkan coba lagi']);
        }
    }

    public function destroyTeacher($id)
    {
        DB::beginTransaction();
        try {
            $teacher = Teacher::with('user')->findOrFail($id);

            if ($teacher->foto) {
                Storage::disk('public')->delete($teacher->foto);
            }

            $teacher->user->delete();

            // $teacher->delete();
            DB::commit();
            Alert::success('Success', 'Berhasil Hapus Guru');
            return redirect()->route('teachers.show');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()
                ->withInput()
                ->withErrors('general', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }
}
