<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonContent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LessonContentController extends Controller
{
    // Get lesson content in a selected language
    public function index(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:tbl_lessons,id',
            'language' => ['required', Rule::in(['en', 'hi'])],
        ]);

        $content = LessonContent::where('lesson_id', $validated['lesson_id'])
            ->where('language', $validated['language'])
            ->first();

        if (!$content) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson content is not available in this language.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $content,
        ]);
    }

    // Create or update content for a language
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:tbl_lessons,id',
            'language' => ['required', Rule::in(['en', 'hi'])],
            'content' => 'required|string',
            'learning_objectives' => 'nullable|string',
            'key_points' => 'nullable|string',
        ]);

        $lessonContent = LessonContent::updateOrCreate(
            [
                'lesson_id' => $validated['lesson_id'],
                'language' => $validated['language'],
            ],
            [
                'content' => $validated['content'],
                'learning_objectives' => $validated['learning_objectives'] ?? null,
                'key_points' => $validated['key_points'] ?? null,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Lesson content saved successfully.',
            'data' => $lessonContent,
        ], 201);
    }

    // Get content by ID
    public function show($id)
    {
        $content = LessonContent::with('lesson')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $content,
        ]);
    }

    // Update existing content
    public function update(Request $request, $id)
    {
        $lessonContent = LessonContent::findOrFail($id);

        $validated = $request->validate([
            'content' => 'sometimes|required|string',
            'learning_objectives' => 'nullable|string',
            'key_points' => 'nullable|string',
        ]);

        $lessonContent->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lesson content updated successfully.',
            'data' => $lessonContent->fresh(),
        ]);
    }

    // Delete content
    public function destroy($id)
    {
        $content = LessonContent::findOrFail($id);
        $content->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lesson content deleted successfully.',
        ]);
    }

    // Get all available language versions for a lesson
    public function languages($lessonId)
    {
        $lesson = Lesson::with('contents:id,lesson_id,language')
            ->findOrFail($lessonId);

        return response()->json([
            'success' => true,
            'lesson_id' => $lesson->id,
            'available_languages' => $lesson->contents
                ->pluck('language')
                ->values(),
        ]);
    }
}
