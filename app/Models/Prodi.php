<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    // access student through kelas
    public function students()
    {
        return $this->hasManyThrough(Student::class, Kelas::class);
    }
}
