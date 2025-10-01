<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    /** @use HasFactory<\Database\Factories\QuizFactory> */
    // use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function comments()
    {
        // get newest comment first, this is what shows in the UI
        return $this->hasMany(Comment::class)
            ->whereNull('parent_id')
            ->latest();
    }

    public function teacherSubjectClass()
    {
        return $this->belongsTo(TeacherSubjectClass::class);
    }

    public function getTeacherNameAttribute()
    {
        return $this->teacherSubjectClass->teacher->user->name ?? null;
    }
}
