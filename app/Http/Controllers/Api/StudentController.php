<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Student;
class StudentController extends Controller
{
    public function index()
    {
        
        $student = Student::all();

        return response()->json([
            'success' => true,
            'data' => $student,
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'roll_no' => 'required|integer|min:1|unique:students,roll_no',
            'section' => 'required|string|max:100',
            'class'   => 'required|string|max:100',
            'email'   => 'required|email|max:255|unique:students,email',
            'image'   => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('image')->store('students', 'public');

        $validated['image'] = $path;

        $student = Student::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }

    public function show(string $id){
        $student = Student::find($id);
        if(!$student){
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ],404);

        }
        return response()->json([
            'success' => true,
            'data' => $student

        ],200);
    }

    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

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
            $path = $request->file('image')->store('students', 'public');
            $validated['image'] = $path;
        }

        $student->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'data' => $student->fresh()
        ], 200);
    }
    public function destroy(string $id){
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted SuccessFully'
        ],200);
    }
}