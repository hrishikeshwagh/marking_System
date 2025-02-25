<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model {
    use HasFactory;

    protected $fillable = ['student_id', 'assignment_id', 'component_id', 'marks_obtained'];

    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }

    public function component() {
        return $this->belongsTo(Component::class);
    }
    public function marks() {
        return $this->hasMany(Mark::class, 'assignment_id');
    }
}
