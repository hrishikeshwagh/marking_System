<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'student_id', 'status'];

    public function marks() {
        return $this->hasMany(Mark::class, 'assignment_id', 'id');
    }
}
