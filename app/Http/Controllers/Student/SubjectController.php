<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;

class SubjectController extends Controller
{
    public function chapters($classSubjectId)
    {
        $classSubject = ClassSubject::with([
            'academicClass',
            'subject',
            'chapters' => function ($query) {
                $query->where('is_published', true)
                    ->withCount([
                        'lessons' => function ($lessonQuery) {
                            $lessonQuery->where('is_published', true);
                        }
                    ])
                    ->orderBy('chapter_number');
            }
        ])
        ->whereHas('subject', function ($query) {
            $query->where('is_active', true);
        })
        ->findOrFail($classSubjectId);

        return view('student.chapters.index', compact('classSubject'));
    }
}
