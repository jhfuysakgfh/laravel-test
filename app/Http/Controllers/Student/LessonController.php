<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Chapter;

class LessonController extends Controller
{
    public function index($chapterId)
    {
        $chapter = Chapter::with([
            'classSubject.academicClass',
            'classSubject.subject',
            'lessons' => function ($query) {
                $query->where('is_published', true)
                    ->orderBy('lesson_number');
            }
        ])
        ->where('is_published', true)
        ->findOrFail($chapterId);

        return view('student.lessons.index', compact('chapter'));
    }
   public function show($lessonId)
{
    $lesson = \App\Models\Lesson::with([
        'chapter.classSubject.academicClass',
        'chapter.classSubject.subject',
        'contents'
    ])
    ->where('is_published', true)
    ->findOrFail($lessonId);

    return view('student.lessons.show', compact('lesson'));
}
}
