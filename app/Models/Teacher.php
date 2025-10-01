<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // pivot relation
    public function  teacherSubjectClasses()
    {
        return $this->hasMany(TeacherSubjectClass::class);
    }

    // category = category subject (through pivot)
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'teacher_subject_class')
                ->withPivot('kelas_id')
                ->withTimestamps();
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'teacher_subject_class')
                ->withPivot('category_id')
                ->withTimestamps();
    }

    // direct relation to get category + kelas
    public function assignments()
    {
        return $this->hasMany(TeacherSubjectClass::class);
    }

    // helper to avoid duplicate categories/kelas in views
    public function uniqueCategories()
    {
        return $this->categories()->distinct();
    }

    public function uniqueKelas()
    {
        return $this->kelas()->distinct();
    }



    // teacher functionalities
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    // helper to get the name
    public function getNameAttribute()
    {
        return $this->user->name;
    }
}
