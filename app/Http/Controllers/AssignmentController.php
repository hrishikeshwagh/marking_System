<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\Mark;
use App\Models\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;





class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Assignment::all());
    }

    public function store(Request $request)
    {
        $assignment = Assignment::create($request->all());
        return response()->json($assignment, 201);
    }

    public function updateAssignmentStatus(Request $request)
    {

        //die("-----------");
        $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'assignment_id' => 'required|integer|exists:assignments,id',
            'status' => 'required|string|in:pending,in-progress,completed',
        ]);

        $assignment = Assignment::where('id', $request->assignment_id)
                                ->where('student_id', $request->student_id)
                                ->first();

        if (!$assignment) {
            return response()->json(['message' => 'Assignment not found'], 404);
        }

        $assignment->status = $request->status;
        $assignment->save();

        return response()->json([
            'message' => 'Assignment status updated successfully',
            'assignment' => $assignment
        ]);
    }


    public function getAssignmentsByStudent($student_id): JsonResponse
{
    $assignments = Assignment::where('student_id', $student_id)->get();

    if ($assignments->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'No assignments found for this student',
            'data' => []
        ], 404); // Not Found
    }

    return response()->json([
        'status' => true,
        'message' => 'Assignments retrieved successfully',
        'data' => $assignments
    ], 200); // OK
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
