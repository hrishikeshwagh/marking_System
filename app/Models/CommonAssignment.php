<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonAssignment extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status'];
    protected $hidden = ['status']; // Hide status from API response

}
