<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\Mark;
use App\Models\Component;
use Illuminate\Http\JsonResponse;
use DB;
use Illuminate\Support\Facades\Log;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

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
    public function storeMarks(Request $request)
{
    DB::beginTransaction();

    try {
        // Log received data
        Log::info('Received Data:', $request->all());

        // Insert marks for each component
        foreach ($request->marks as $markData) {
            Mark::create([
                'student_id' => $request->student_id,
                'assignment_id' => $request->assignment_id,
                'component_id' => $markData['component_id'],
                'marks_obtained' => $markData['marks_obtained'],
                'grade' => null, // Grade calculation will be added later
            ]);
        }

        // Check if all marks are filled
        $assignment = Assignment::find($request->assignment_id);
        $allMarksFilled = $assignment->marks()->whereNull('marks_obtained')->doesntExist();

        // Determine new status
        $newStatus = $allMarksFilled ? 'completed' : 'in-progress';

        // Update assignment status
        $assignment->update(['status' => $newStatus]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Marks added successfully',
            'assignment_status' => $newStatus,
            'all_marks' => Mark::where('student_id', $request->student_id)
                               ->where('assignment_id', $request->assignment_id)
                               ->get()
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error inserting marks: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Error saving marks',
            'error' => $e->getMessage()
        ], 500);
    }
}


    private function calculateGrade($percentage)
    {
        if ($percentage >= 95) return 'A+';
        if ($percentage >= 85) return 'A';
        if ($percentage >= 75) return 'B+';
        if ($percentage >= 65) return 'B';
        if ($percentage >= 50) return 'C';
        return 'F';
    }
    
//     public function storeMarks(Request $request)
// {
//     Log::info('Received Data:', $request->all());

//     return response()->json([
//         'message' => 'Check logs'
//     ]);
// }
}
