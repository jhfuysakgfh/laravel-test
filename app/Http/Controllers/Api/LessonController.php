<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LessonController extends Controller
{
    // List lessons by chapter
    public function index(Request $request)
    {
        $request->validate([
            'chapter_id' => 'required|exists:tbl_chapters,id',
        ]);

        $lessons = Lesson::with(['contents', 'resources'])
            ->where('chapter_id', $request->chapter_id)
            ->orderBy('lesson_number')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $lessons,
        ]);
    }

    // Create lesson
    public function store(Request $request)
    {
        $validated = $request->validate([
            'chapter_id' => 'required|exists:tbl_chapters,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('tbl_lessons', 'lesson_number')
                    ->where('chapter_id', $request->chapter_id),
            ],
            'estimated_minutes' => 'nullable|integer|min:1',
            'is_published' => 'sometimes|boolean',
        ]);

        $lesson = Lesson::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lesson created successfully.',
            'data' => $lesson,
        ], 201);
    }

    // Show lesson
    public function show($id)
    {
        $lesson = Lesson::with(['chapter', 'contents', 'resources'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $lesson,
        ]);
    }

    // Update lesson
    public function update(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);

        $validated = $request->validate([
            'chapter_id' => 'sometimes|exists:tbl_chapters,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'lesson_number' => [
                'sometimes',
                'integer',
                'min:1',
                Rule::unique('tbl_lessons', 'lesson_number')
                    ->where(
                        'chapter_id',
                        $request->input('chapter_id', $lesson->chapter_id)
                    )
                    ->ignore($lesson->id),
            ],
            'estimated_minutes' => 'sometimes|integer|min:1',
            'is_published' => 'sometimes|boolean',
        ]);

        $lesson->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lesson updated successfully.',
            'data' => $lesson->fresh(),
        ]);
    }

    // Delete lesson
    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lesson deleted successfully.',
        ]);
    }
}
