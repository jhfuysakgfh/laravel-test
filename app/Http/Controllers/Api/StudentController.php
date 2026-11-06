<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Student;

class StudentController extends Controller
{
    // Get only the logged-in user's students
    public function index(Request $request)
    {
        $students = $request->user()->students()->get();

        return response()->json([
            'success' => true,
            'data' => StudentResource::collection($students),
        ], 200);
    }

    // Create student and automatically assign owner
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'roll_no' => 'required|integer|min:1|unique:students,roll_no',
            'section' => 'required|string|max:100',
            'class' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:students,email',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('image')->store('students', 'public');

        $validated['image'] = $path;

        // Automatically assigns authenticated user's ID
        $student = $request->user()->students()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => new StudentResource($student)
        ], 201);
    }

    // Get one student belonging to logged-in user
    public function show(Request $request, string $id)
    {
        $student = $request->user()->students()->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new StudentResource($student),
        ], 200);
    }

    // Fully update a student
    public function update(Request $request, string $id)
    {
        $student = $request->user()->students()->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'roll_no' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('students', 'roll_no')->ignore($student->id)
            ],

            'section' => 'required|string|max:100',
            'class' => 'required|string|max:100',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($student->id)
            ],

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('students', 'public');
        }

        $student->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'data' => new StudentResource($student->fresh())
        ], 200);
    }

    // Partially update a student
    public function patch(Request $request, string $id)
    {
        $student = $request->user()->students()->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',

            'roll_no' => [
                'sometimes',
                'required',
                'integer',
                'min:1',
                Rule::unique('students', 'roll_no')->ignore($student->id)
            ],

            'section' => 'sometimes|required|string|max:100',
            'class' => 'sometimes|required|string|max:100',

            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($student->id)
            ],

            'image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if (empty($validated)) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide at least one field to update'
            ], 422);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('students', 'public');
        }

        $student->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student partially updated successfully',
            'data' => new StudentResource($student->fresh())
        ], 200);
    }

    // Delete only the logged-in user's student
    public function destroy(Request $request, string $id)
    {
        $student = $request->user()->students()->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully'
        ], 200);
    }
}
