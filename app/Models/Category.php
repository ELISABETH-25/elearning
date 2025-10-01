<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // public function chapters()
    // {
    //     return $this->hasMany(Chapter::class);
    // }


    // pivot
    public function teacherSubjectClasses()
    {
        return $this->hasMany(TeacherSubjectClass::class);
    }


    // access chapters via teacherSubjectClass
    public function chapters()
    {
        return $this->hasManyThrough(
            Chapter::class,
            TeacherSubjectClass::class,
            'category_id',
            'teacher_subject_class_id',
            'id', //FK category
            'id' //FK teacher_subject_class
        );
    }


    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subject_class')
            ->withPivot('kelas_id')
            ->withTimestamps();
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'teacher_subject_class')
            ->withPivot('teacher_id')
            ->withTimestamps();
    }

    // to connect category with kelas, directly even without assign it to a teacher
    public function kelasDirect()
    {
        return $this->belongsToMany(Kelas::class, 'category_kelas')
            ->distinct()
            ->withTimestamps();
    }
}
