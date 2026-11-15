<?php


use App\Models\Payment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Models\Book;
use App\Models\AcademicClass;
use App\Models\Lesson;
use App\Models\User;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Student\AuthController as StudentAuthController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\SubjectController;
use App\Http\Controllers\Student\LessonController;

Route::get('/', function () {
    return view('home');
});

Route::get('/test', function () {
    return view('welcometest');
});


Route::get('/payment-test/{id}', function ($id) {
    $payment = Payment::findOrFail($id);

    return view('payment-test', compact('payment'));
});


Route::prefix('admin')->name('admin.')->group(function () {

    // Admin login page
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    // Process admin login
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

    // Admin logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware(['auth', 'admin'])
        ->name('logout');

     Route::get('/dashboard', function () {

    $totalBooks = Book::count();

    $totalClasses = AcademicClass::count();

    $totalLessons = Lesson::count();

    $totalStudents = User::where('role', 'student')->count();

    return view('admin.dashboard', compact(
        'totalBooks',
        'totalClasses',
        'totalLessons',
        'totalStudents'
    ));

})
->middleware(['auth', 'admin'])
->name('dashboard');
// Admin Books listing
Route::get('/books', [BookController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('books.index');

});

// Student Authentication Routes
// Student Authentication Routes
Route::prefix('student')->name('student.')->group(function () {

    Route::get('/login', [StudentAuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [StudentAuthController::class, 'login'])
        ->name('login.submit');

    Route::middleware(['auth', 'student'])->group(function () {

        Route::post('/logout', [StudentAuthController::class, 'logout'])
            ->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('/subjects/{classSubjectId}/chapters',[SubjectController::class, 'chapters'])->name('subjects.chapters');

        Route::get('/chapters/{chapterId}/lessons', [LessonController::class, 'index'])
    ->name('chapters.lessons');
    Route::get('/lessons/{lessonId}', [LessonController::class, 'show'])
    ->name('lessons.show');

    });

});