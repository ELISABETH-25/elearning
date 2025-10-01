<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Chapter extends Model
{
    use HasFactory;


    protected $guarded = ['id'];
    protected $with = ['topics'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function teacherSubjectClass()
    {
        return $this->belongsTo(TeacherSubjectClass::class);
    }
}
