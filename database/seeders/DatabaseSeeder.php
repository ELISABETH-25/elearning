<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Chapter;
use App\Models\Topic;
use App\Models\Quiz;
use App\Models\Category;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherSubjectClass;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345'),
            'role'  => 'admin',
        ]);

        User::create([
            'name' => 'guru',
            'email' => 'guru@gmail.com',
            'password' => bcrypt('12345'),
            'role'  => 'teacher',
        ]);

        User::create([
            'name' => 'siswa',
            'email' => 'siswa@gmail.com',
            'password' => bcrypt('12345'),
            'role'  => 'student',
        ]);

        Teacher::create([
            'user_id' => 2,
            'gender' => 'L',
            'date_of_birth' => '1999-01-01',
            'domisili' => 'NTB',
            'phone' => '081234567',
            'nip' => '123456',
            'jabatan' => 'Guru Mata Pelajaran',
            'alamat' => 'Kabupaten Lembata, NTT',
            'tahun_masuk' => '2022-01-01',
            'agama' => 'Kristen',
            'foto' => null,
        ]);

        Student::factory(50)->create();


        Subject::create([
            'name' => 'Bahasa Indonesia'
        ]);

        Subject::create([
            'name' => 'Sejarah Indonesia'
        ]);

        Prodi::create([
            'name' => 'Teknik Komputer dan Jaringan',
            'kode' => 'TKJ',
        ]);

        Prodi::create([
            'name' => 'Teknik Permesinan',
            'kode' => 'TP',
        ]);

        Prodi::create([
            'name' => 'Agribisnis Ternak Unggas',
            'kode' => 'ATU',
        ]);

        Prodi::create([
            'name' => 'Agribisnis Tanaman Pangan dan Hortikultura',
            'kode' => 'ATPH',
        ]);

        Prodi::create([
            'name' => 'Agribisnis Perikanan Air Tawar',
            'kode' => 'APAT',
        ]);

        Prodi::create([
            'name' => 'Nautika Kapal Penangkap Ikan.',
            'kode' => 'NKPI',
        ]);

        Kelas::create([
            'prodi_id' => 1,
            'name' => 'X TKJ-A',
            'tingkat' => 'X',
        ]);

        Kelas::create([
            'prodi_id' => 1,
            'name' => 'X TKJ-B',
            'tingkat' => 'X',
        ]);

        Kelas::create([
            'prodi_id' => 3,
            'name' => 'X ATU',
            'tingkat' => 'X',
        ]);

        Kelas::create([
            'prodi_id' => 2,
            'name' => 'X TP',
            'tingkat' => 'X',
        ]);

        Kelas::create([
            'prodi_id' => 4,
            'name' => 'X ATPH',
            'tingkat' => 'X',
        ]);

        Kelas::create([
            'prodi_id' => 5,
            'name' => 'X APAT',
            'tingkat' => 'X',
        ]);

        Kelas::create([
            'prodi_id' => 6,
            'name' => 'X NKPI',
            'tingkat' => 'X',
        ]);

        Kelas::create([
            'prodi_id' => 2,
            'name' => 'XI TP',
            'tingkat' => 'XI',
        ]);

        Kelas::create([
            'prodi_id' => 4,
            'name' => 'XI ATPH',
            'tingkat' => 'XI',
        ]);

        

        Kelas::create([
            'prodi_id' => 1,
            'name' => 'XI TKJ-A',
            'tingkat' => 'XI',
        ]);

        Kelas::create([
            'prodi_id' => 1,
            'name' => 'XI TKJ-B',
            'tingkat' => 'XI',
        ]);

        Kelas::create([
            'prodi_id' => 3,
            'name' => 'XI ATU',
            'tingkat' => 'XI',
        ]);

        Kelas::create([
            'prodi_id' => 5,
            'name' => 'XI APAT',
            'tingkat' => 'XI',
        ]);

        Kelas::create([
            'prodi_id' => 6,
            'name' => 'XI NKPI',
            'tingkat' => 'XI',
        ]);

        Kelas::create([
            'prodi_id' => 2,
            'name' => 'XII TP',
            'tingkat' => 'XII',
        ]);

        Kelas::create([
            'prodi_id' => 4,
            'name' => 'XII ATPH',
            'tingkat' => 'XII',
        ]);

        Kelas::create([
            'prodi_id' => 5,
            'name' => 'XII APAT',
            'tingkat' => 'XII',
        ]);

        Kelas::create([
            'prodi_id' => 6,
            'name' => 'XII NKPI',
            'tingkat' => 'XII',
        ]);

        Kelas::create([
            'prodi_id' => 1,
            'name' => 'XII TKJ-A',
            'tingkat' => 'XII',
        ]);

        Kelas::create([
            'prodi_id' => 1,
            'name' => 'XII TKJ-B',
            'tingkat' => 'XII',
        ]);

        Kelas::create([
            'prodi_id' => 3,
            'name' => 'XII ATU',
            'tingkat' => 'XII',
        ]);


        Category::create([
            'name' => 'Bahasa Inggris 1',
        ]);

        Category::create([
            'name' => 'Bahasa Inggris 2',
        ]);

        Category::create([
            'name' => 'Bahasa Inggris 3',
        ]);

        Category::create([
            'name' => 'Bahasa Inggris 1',
        ]);

        Category::create([
            'name' => 'Matematika 1',
        ]);

        Category::create([
            'name' => 'Matematika 2',
        ]);

        Category::create([
            'name' => 'Matematika 3',
        ]);

        Category::create([
            'name' => 'Ilmu Pengetahuan Alam (IPA) 1',
        ]);

        Category::create([
            'name' => 'Ilmu Pengetahuan Alam (IPA) 2',
        ]);

        Category::create([
            'name' => 'Ilmu Pengetahuan Alam (IPA) 3',
        ]);

        Category::create([
            'name' => 'Ilmu Pengetahuan Sosial (IPS) 1',
        ]);

        Category::create([
            'name' => 'Ilmu Pengetahuan Sosial (IPS) 2',
        ]);

        Category::create([
            'name' => 'Ilmu Pengetahuan Sosial (IPS) 3',
        ]);

        Category::create([
            'name' => 'Pendidikan Pancasila dan Kewarganegaraan (PPKn) 1',
        ]);

        Category::create([
            'name' => 'Pendidikan Pancasila dan Kewarganegaraan (PPKn) 2',
        ]);

        Category::create([
            'name' => 'Pendidikan Pancasila dan Kewarganegaraan (PPKn) 3',
        ]);

        Category::create([
            'name' => 'Dasar-Dasar Komputer',
        ]);

        Category::create([
            'name' => 'Sistem Operasi',
        ]);

        Category::create([
            'name' => 'Pemrograman 1',
        ]);

        Category::create([
            'name' => 'Pemrograman 2',
        ]);

        Category::create([
            'name' => 'Pemrograman 3',
        ]);

        Category::create([
            'name' => 'Keamanan Jaringan 1',
        ]);

        Category::create([
            'name' => 'Keamanan Jaringan 2',
        ]);

        Category::create([
            'name' => 'Keamanan Jaringan 3',
        ]);

        Category::create([
            'name' => 'Kewirausahaan 1',
        ]);

        Category::create([
            'name' => 'Kewirausahaan 2',
        ]);

        Category::create([
            'name' => 'Kewirausahaan 3',
        ]);

        Category::create([
            'name' => 'Jaringan Komputer 1',
        ]);

        Category::create([
            'name' => 'Jaringan Komputer 2',
        ]);

        Category::create([
            'name' => 'Jaringan Komputer 3',
        ]);
        

        TeacherSubjectClass::create([
            'teacher_id' => 1,
            'category_id' => 17,
            'kelas_id' => 1,
        ]);

        // Chapter::factory(5)->create();

        Chapter::create([
            'judul' => 'Teks Deskripsi',
            'teacher_subject_class_id' => 1,
        ]);

        Topic::create([
            'judul' => 'Teks Deskripsi',
            'chapter_id' => 1,
            'teacher_subject_class_id' => 1,
            'body' => 'lorem ipsum',
            'deadline' => '2025-08-25',
        ]);


        Quiz::create([
            'judul' => 'Evaluasi Teks Deskripsi',
            'topic_id' => 1,
            'teacher_subject_class_id' => 1,
            'body' => 'aac',
            'deadline' => '2025-08-25',
        ]);

    }
}
