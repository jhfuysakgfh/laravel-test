<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\RequestTestController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RazorpayWebhookController;

use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/hello', function () {
    return response()->json([
        'success' => true,
        'message' => 'My first Laravel API is working!'
    ]);
});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::patch('/products/{id}', [ProductController::class, 'patch']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    Route::get('/student', [StudentController::class, 'index']);
    Route::post('/student', [StudentController::class, 'store']);
    Route::get('/student/{id}', [StudentController::class, 'show']);
    Route::put('/student/{id}', [StudentController::class, 'update']);
    Route::patch('/student/{id}', [StudentController::class, 'patch']);
    Route::delete('/student/{id}', [StudentController::class, 'destroy']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::patch('/profile', [ProfileController::class, 'patch']);

    Route::post('/payments/create-order', [PaymentController::class, 'createOrder']);
    Route::post('/payments/verify', [PaymentController::class, 'verifyPayment']);

    
    // Route::get('/forbidden-test', function () {
    //     throw new \Illuminate\Auth\Access\AuthorizationException('Access denied.');
    //     });
    // Route::get('/server-error-test', function () 
    //     {throw new \RuntimeException('This is a test server error.');
    //     });
});
        
        Route::get('/test-request', [RequestTestController::class, 'test']);
        
Route::post('/razorpay/webhook', [RazorpayWebhookController::class,'handle']);
        // Public authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected authentication routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});