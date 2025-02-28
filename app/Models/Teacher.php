<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password'];

    /**
     * Automatically hash the password when creating or updating a teacher.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($teacher) {
            $teacher->password = Hash::make($teacher->password);
        });

        static::updating(function ($teacher) {
            if ($teacher->isDirty('password')) {
                $teacher->password = Hash::make($teacher->password);
            }
        });
    }
}
