<?php


use App\Models\Payment;
use Illuminate\Support\Facades\Route;

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