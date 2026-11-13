<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\ClassSubject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChapterController extends Controller
{
    // List chapters by class and subject
    public function index(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:tbl_classes,id',
            'subject_id' => 'required|exists:tbl_subjects,id',
        ]);

        $classSubject = ClassSubject::where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->firstOrFail();

        $chapters = Chapter::where('class_subject_id', $classSubject->id)
            ->withCount('lessons')
            ->orderBy('chapter_number')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $chapters,
        ]);
    }

    // Create chapter
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_subject_id' => 'required|exists:tbl_class_subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'chapter_number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('tbl_chapters', 'chapter_number')
                    ->where('class_subject_id', $request->class_subject_id),
            ],
            'is_published' => 'sometimes|boolean',
        ]);

        $chapter = Chapter::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Chapter created successfully.',
            'data' => $chapter,
        ], 201);
    }

    // Show chapter
    public function show($id)
    {
        $chapter = Chapter::with('lessons')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $chapter,
        ]);
    }

    // Update chapter
    public function update(Request $request, $id)
    {
        $chapter = Chapter::findOrFail($id);

        $validated = $request->validate([
            'class_subject_id' => 'sometimes|exists:tbl_class_subjects,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'chapter_number' => [
                'sometimes',
                'integer',
                'min:1',
                Rule::unique('tbl_chapters', 'chapter_number')
                    ->where(
                        'class_subject_id',
                        $request->input('class_subject_id', $chapter->class_subject_id)
                    )
                    ->ignore($chapter->id),
            ],
            'is_published' => 'sometimes|boolean',
        ]);

        $chapter->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Chapter updated successfully.',
            'data' => $chapter->fresh(),
        ]);
    }

    // Delete chapter
    public function destroy($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->delete();

        return response()->json([
            'success' => true,
            'message' => 'Chapter deleted successfully.',
        ]);
    }
}
