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

    public function store(Request $request) {
        $assignment = Assignment::updateOrCreate(
            [
                'student_id' => $request->student_id, 
                'title' => $request->title
            ],
            [
                'status' => $request->status
            ]
        );
    
        return response()->json(['message' => 'Assignment saved successfully!', 'assignment' => $assignment], 201);
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


//     public function getAssignmentsByStudent($student_id): JsonResponse
// {
//     $assignments = Assignment::where('student_id', $student_id)->get();

//     if ($assignments->isEmpty()) {
//         return response()->json([
//             'status' => false,
//             'message' => 'No assignments found for this student',
//             'data' => []
//         ], 404); // Not Found
//     }

//     return response()->json([
//         'status' => true,
//         'message' => 'Assignments retrieved successfully',
//         'data' => $assignments
//     ], 200); // OK
// }


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

    // public function getAssignmentsByStudent($student_id) {
    //     $assignments = Assignment::where('student_id', $student_id)
    //         ->with(['marks' => function ($query) {
    //             $query->select('assignment_id', 'component_id', 'marks_obtained');
    //         }])
    //         ->get();

    //     $assignments = $assignments->map(function ($assignment) {
    //         $totalMarksObtained = $assignment->marks->sum('marks_obtained');
    //         $grade = $this->calculateGrade($totalMarksObtained);

    //         return [
    //             'id' => $assignment->id,
    //             'student_id' => $assignment->student_id,
    //             'title' => $assignment->title,
    //             'status' => $assignment->status,
    //             'total_marks_obtained' => $totalMarksObtained,
    //             'grade' => $grade,
    //             'marks' => $assignment->marks->map(function ($mark) {
    //                 return [
    //                     'component_id' => $mark->component_id,
    //                     'marks_obtained' => $mark->marks_obtained
    //                 ];
    //             }),
    //         ];
    //     });

    //     return response()->json([
    //         'student_id' => $student_id,
    //         'assignments' => $assignments
    //     ], 200);
    // }

    public function getAssignmentsByStudent($student_id)
{
    $assignments = Assignment::where('student_id', $student_id)
        ->with(['marks' => function ($query) {
            $query->select('assignment_id', 'component_id', 'marks_obtained');
        }])
        ->get();

    $assignments->transform(function ($assignment) {
        $total_marks = $assignment->marks->sum('marks_obtained'); // Sum of marks obtained

        // Grade calculation logic based on total marks
        $grade = $this->calculateGrade($total_marks);

        return [
            'id' => $assignment->id,
            'student_id' => $assignment->student_id,
            'title' => $assignment->title,
            'status' => $assignment->status,
            'total_marks_obtained' => $total_marks,
            'grade' => $grade,
            'marks' => $assignment->marks->map(function ($mark) {
                return [
                    'component_id' => $mark->component_id,
                    'marks_obtained' => $mark->marks_obtained,
                ];
            }),
        ];
    });

    return response()->json([
        'student_id' => $student_id,
        'assignments' => $assignments
    ], 200);
}

// Helper function to calculate grade
private function calculateGrade($total_marks)
{
    if ($total_marks >= 95) {
        return 'A+';
    } elseif ($total_marks >= 85) {
        return 'A';
    } elseif ($total_marks >= 75) {
        return 'B+';
    } elseif ($total_marks >= 65) {
        return 'B';
    } elseif ($total_marks >= 50) {
        return 'C';
    } else {
        return 'F';
    }
}

}
