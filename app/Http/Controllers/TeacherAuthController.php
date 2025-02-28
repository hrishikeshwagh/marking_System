<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;



class TeacherAuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //echo password_hash('password123', PASSWORD_BCRYPT);

    
        // Find teacher by email
        $teacher = Teacher::where('email', $request->email)->first();
        //$plainPassword = '123456';
// $hashedPassword = Hash::make($plainPassword);

// echo $hashedPassword;

//     print ($request->password) ;echo"<pre>";  print_r($teacher);die;
    
        // ❌ Check if teacher exists and password matches
        if (!$teacher || !Hash::check($request->password, $teacher->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        
    
        // Generate auth token
        $token = $teacher->createToken('teacher-auth-token')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'teacher' => [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'email' => $teacher->email
            ]
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}
