<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show student login page
     */
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->role === 'student') {
            return redirect()->route('student.dashboard');
        }

        return view('student.auth.login');
    }

    /**
     * Handle student login
     */
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Find user by email
        $user = \App\Models\User::where('email', $credentials['email'])
            ->first();

        // Check user exists and is a student
        if (!$user || $user->role !== 'student') {
            return back()
                ->withErrors([
                    'email' => 'Invalid student credentials.'
                ])
                ->onlyInput('email');
        }

        // Verify password
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors([
                    'email' => 'Invalid student credentials.'
                ])
                ->onlyInput('email');
        }

        // Login student using web session
        Auth::login($user);

        // Regenerate session ID
        $request->session()->regenerate();

        // Redirect to student dashboard
        return redirect()
            ->intended(route('student.dashboard'))
            ->with('success', 'Welcome back!');
    }

    /**
     * Student logout
     */
    public function logout(Request $request)
    {
        // Logout current student session
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect()
            ->route('student.login')
            ->with('success', 'You have logged out successfully.');
    }
}
