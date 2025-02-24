<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\Mark;
use App\Models\Component;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('assignments:id,student_id,title,status')->get();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:15'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create student
        $student = Student::create([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        return response()->json([
            'message' => 'Student created successfully',
            'student' => $student
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
