<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with([
            'classSubject.academicClass.board',
            'classSubject.subject'
        ])
        ->latest()
        ->get();

        return view('admin.books.index', compact('books'));
    }
}