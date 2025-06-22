<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marks;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function subjectAnalysis()
    {
        $marks = Marks::with(['student', 'subject'])->get();

        // Group marks by subject
        $subjectStats = $marks->groupBy('subject_id')->map(function ($group) {
            // Get subject name from first item
            $subjectName = $group->first()->subject->name;

            // Get the highest scorer
            $highest = $group->sortByDesc('marks')->first();
            $highestScore = $highest->marks;
            $highestStudent = $highest->student->name;

            // Get the lowest scorer
            $lowest = $group->sortBy('marks')->first();
            $lowestScore = $lowest->marks;
            $lowestStudent = $lowest->student->name;

            return [
                'subject' => $subjectName,
                'highest_score' => $highestScore,
                'highest_scorer' => $highestStudent,
                'lowest_score' => $lowestScore,
                'lowest_scorer' => $lowestStudent,
            ];
        })->values();

        return response()->json($subjectStats, 200);
    }

    public function chartData()
    {
        $marks = Marks::with('subject')->get();

        // subject names and average scores
        $subjectAverages = $marks->groupBy('subject_id')->map(function ($group) {
            return [
                'subject' => $group->first()->subject->name,
                'average' => round($group->avg('marks'), 2),
            ];
        })->values();

        // split into chart arrays
        $chartLabels = $subjectAverages->pluck('subject')->toArray();
        $chartData = $subjectAverages->pluck('average')->toArray();

        return response()->json([
            'labels' => $chartLabels,
            'data' => $chartData
        ], 200);
    }
}
