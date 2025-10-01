<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $guarded = ['id'];

    public function teacherSubjects()
    {
        return $this->hasMany(TeacherSubjectClass::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subject_class')
            ->withPivot('category_id')
            ->withTimestamps();
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'teacher_subject_class')
            ->withPivot('teacher_id')
            ->withTimestamps();
    }

    // directly to categories
    public function categoriesDirect()
    {
        return $this->belongsToMany(Category::class, 'category_kelas')
            ->withTimestamps()
            ->distinct();
    }
}
