<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marks;
use App\Models\Students;
use App\Models\Subjects;
use Illuminate\Http\Request;

class CsvController extends Controller
{
    protected $csvData = [];
    public function __construct()
    {
        $path = storage_path('app/student_marks.csv');

        if (file_exists($path) && ($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle); // Read column headers
            while (($row = fgetcsv($handle)) !== false) {
                $this->csvData[] = array_combine($header, $row); // Match row values to headers
            }
            fclose($handle);
        }
    }

    public function importData()
    {
        // Saving student details
        // Loop through all records to collect student details
        foreach ($this->csvData as $row) {
            $name = $row['first_name'] . ' ' . $row['last_name'];

            $student = Students::updateOrCreate(
                ['index_no' => $row['index_no']],
                ['name' => $name]
            );
            $allStudents[] = $student; // collect each student
        }

        // Saving subjects
        // Loop through all records to collect subject names
        $subjectNames = [];

        foreach ($this->csvData as $row) {
            foreach ($row as $key => $value) {
                if (!in_array($key, ['index_no', 'first_name', 'last_name'])) {
                    $subjectNames[] = $key; // keys from json store in to $subjectNames
                }
            }
        }
        // remove duplicates
        $uniqueSubjects = array_unique($subjectNames);

        // insert each subject if it didn't exists
        foreach ($uniqueSubjects as $subjectNames) {
            $subject = Subjects::firstOrCreate(['name' => $subjectNames]);

            $allSubjects[] = $subject;
        }

        // Saving subject marks
        foreach ($this->csvData as $row) {
            $indexNo = $row['index_no'];

            foreach ($row as $key => $value) {
                if (!in_array($key, ['index_no', 'first_name', 'last_name'])) {
                    // find subject id
                    $subject = Subjects::where('name', $key)->first();

                    $marks = Marks::updateOrCreate(
                        ['index_no' => $indexNo, 'subject_id' => $subject->id],
                        ['marks' => $value]
                    );
                    $allMarks[] = $marks;
                }
            }
        }

        return response()->json([
            'message' => 'Data Saved Successfully',
            // 'total_students' => count($allStudents),
            // 'total_subjects' => count($allSubjects),
            // 'total_marks' => count($allMarks),
        ]);
    }
}
