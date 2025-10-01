<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
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
