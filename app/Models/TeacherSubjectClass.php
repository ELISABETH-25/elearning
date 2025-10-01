<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSubjectClass extends Model
{
    protected $table = 'teacher_subject_class';

    protected $guarded = ['id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
