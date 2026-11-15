
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Management | AI Teacher</title>

    <style>
        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f5f3ff;
            color: #25213b;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
        }

        .book-card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f8f7fc;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #fff1d6;
            color: #9a6200;
            font-size: 12px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        a {
            color: #6d4aff;
            text-decoration: none;
        }

        .download-btn {
            display: inline-block;
            padding: 9px 14px;
            background: #6d4aff;
            color: white;
            border-radius: 6px;
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
        }

        .download-btn:hover {
            background: #5635d9;
        }

        .not-uploaded {
            color: #999;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .book-card {
                overflow-x: auto;
            }

            table {
                min-width: 850px;
            }

            .header {
                gap: 15px;
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <div>
            <h1>📚 Books Management</h1>
            <p>View all books created in AI Teacher.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}">← Back to Dashboard</a>
    </div>

    <div class="book-card">

        <h2>Total Books: {{ $books->count() }}</h2>

        @if($books->isEmpty())

            <div class="empty">
                No books found.
            </div>

        @else

            <table>
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Board</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Academic Year</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>

                            <td>
                                {{ $book->classSubject?->academicClass?->board?->code ?? '—' }}
                            </td>

                            <td>
                                {{ $book->classSubject?->academicClass?->name ?? '—' }}
                            </td>

                            <td>
                                {{ $book->classSubject?->subject?->name ?? '—' }}
                            </td>

                            <td>
                                {{ $book->academic_year ?? '—' }}
                            </td>

                            <td>
                                <span class="status">
                                    {{ ucfirst($book->status) }}
                                </span>
                            </td>

                            <td>
                                @if($book->pdf_path)
                                    <a
                                        href="{{ asset('storage/' . $book->pdf_path) }}"
                                        class="download-btn"
                                        download
                                    >
                                        ⬇ Download PDF
                                    </a>
                                @else
                                    <span class="not-uploaded">
                                        Not uploaded
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @endif

    </div>

</div>

</body>
</html>
