
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $classSubject->subject->name }} - Chapters</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f4f7fb;
        }

        .navbar {
            background: #102a49;
        }

        .chapter-card {
            border: 1px solid #e5eaf0;
            border-radius: 14px;
            transition: 0.2s;
        }

        .chapter-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .chapter-number {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #eaf2ff;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-dark">
    <div class="container">
        <a href="{{ route('student.dashboard', [
            'class_id' => $classSubject->class_id
        ]) }}" class="navbar-brand fw-bold">
            AI Smart Teacher
        </a>

        <span class="text-white">
            {{ auth()->user()->name }}
        </span>
    </div>
</nav>

<div class="container py-5">

    <a href="{{ route('student.dashboard', [
        'class_id' => $classSubject->class_id
    ]) }}" class="btn btn-outline-primary mb-4">
        ← Back to Dashboard
    </a>

    <div class="mb-4">
        <h2 class="fw-bold">
            {{ $classSubject->subject->name }}
        </h2>

        <p class="text-muted">
            {{ $classSubject->academicClass->name }}
            · Explore your chapters and lessons
        </p>
    </div>

    <h4 class="fw-bold mb-4">Available Chapters</h4>

    <div class="row g-4">

        @forelse($classSubject->chapters as $chapter)

            <div class="col-md-6 col-lg-4">

                <div class="card chapter-card h-100">

                    <div class="card-body p-4">

                        <div class="chapter-number mb-3">
                            {{ $chapter->chapter_number }}
                        </div>

                        <h5 class="fw-bold">
                            {{ $chapter->title }}
                        </h5>

                        <p class="text-muted">
                            {{ $chapter->description ?: 'Explore this chapter and start learning.' }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center">

    <span class="text-muted small">
        {{ $chapter->lessons_count }} Lessons
    </span>

    <a href="{{ route('student.chapters.lessons', [
        'chapterId' => $chapter->id
    ]) }}" class="btn btn-primary btn-sm">
        View Lessons →
    </a>

</div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-info">
                    No published chapters are available for this subject yet.
                </div>
            </div>

        @endforelse

    </div>

</div>

</body>
</html>
