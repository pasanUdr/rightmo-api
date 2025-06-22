<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marks;
use App\Models\Students;
use Illuminate\Http\Request;

use function Pest\Laravel\from;

class StudentController extends Controller
{
    public function showAllMarks()
    {
        $students = Students::select('index_no', 'name')->with(['marks.subject'])->get();

        // Calculate total, average and simplify marks
        $students->map(function ($student) {
            $total = $student->marks->sum('marks');
            $average = $student->marks->avg('marks');

            // Classify students
            if ($average >= 75) {
                $student->grade = 'Distinct';
            } elseif ($average >= 60) {
                $student->grade = 'Credit';
            } elseif ($average >= 40) {
                $student->grade = 'Pass';
            } else {
                $student->grade = 'Fail';
            }

            // Add total and average to the student object
            $student->total_marks = $total;
            $student->average_marks = $average;


            // Simplify subject output
            $student->marks->map(function ($mark) {
                $mark->subject_name = $mark->subject->name;
                unset($mark->subject);
                return $mark;
            });

            return $student;
        });

        // Sort by total marks in descending order
        $students = $students->sortByDesc('total_marks')->values();

        // Add rank based on sorted position
        $students->each(function ($student, $index) {
            $student->rank = $index + 1;
        });

        return response()->json($students, 200);
    }
}
