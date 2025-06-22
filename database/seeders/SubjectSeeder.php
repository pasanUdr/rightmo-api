<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $subjects = [
            [
                'name' => 'Math',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Science',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                
                'name' => 'English',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                
                'name' => 'History',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('subjects')->insert($subjects);
    
    }
}
