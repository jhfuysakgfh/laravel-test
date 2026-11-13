<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicClass;
use App\Models\Subject;
use App\Models\ClassSubject;

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        // Create Class 1 to Class 5
        for ($grade = 1; $grade <= 5; $grade++) {
            AcademicClass::firstOrCreate(
                ['grade_number' => $grade],
                [
                    'name' => 'Class ' . $grade,
                    'description' => 'Learning curriculum for Class ' . $grade,
                    'is_active' => true,
                ]
            );
        }

        // Create subjects
        $subjects = [
            ['name' => 'English', 'slug' => 'english'],
            ['name' => 'Hindi', 'slug' => 'hindi'],
            ['name' => 'Mathematics', 'slug' => 'mathematics'],
            ['name' => 'Environmental Studies', 'slug' => 'evs'],
        ];

        foreach ($subjects as $subjectData) {
            $subject = Subject::firstOrCreate(
                ['slug' => $subjectData['slug']],
                [
                    'name' => $subjectData['name'],
                    'language' => 'both',
                    'description' => $subjectData['name'] . ' subject',
                    'is_active' => true,
                ]
            );

            // Assign each subject to all five classes
            foreach (AcademicClass::all() as $academicClass) {
                ClassSubject::firstOrCreate([
                    'class_id' => $academicClass->id,
                    'subject_id' => $subject->id,
                ]);
            }
        }
    }
}
