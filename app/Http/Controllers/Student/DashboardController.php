<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user();

        // Verify student authentication
        if (!$student || $student->role !== 'student') {
            return redirect()->route('student.login');
        }

        $classes = AcademicClass::where('is_active', true)
            ->with([
                'classSubjects.subject' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->orderBy('grade_number')
            ->get();

        $selectedClass = $classes->firstWhere(
            'id',
            (int) $request->query('class_id')
        );

        if (!$selectedClass) {
            $selectedClass = $classes->first();
        }

        return view('student.dashboard', compact(
            'classes',
            'selectedClass',
            'student'
        ));
    }
}
