
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $chapter->title }} - Lessons</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f4f7fb;
        }

        .navbar {
            background: #102a49;
        }

        .lesson-card {
            border: 1px solid #e5eaf0;
            border-radius: 14px;
            transition: .2s;
        }

        .lesson-card:hover {
            transform: translateY(-3px);
            border-color: #348fe2;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark">
    <div class="container">
        <a href="{{ route('student.dashboard') }}"
           class="navbar-brand fw-bold">
            AI Smart Teacher
        </a>

        <span class="text-white">
            {{ auth()->user()->name }}
        </span>
    </div>
</nav>

<div class="container py-5">

    <a href="{{ route('student.subjects.chapters', [
        'classSubjectId' => $chapter->class_subject_id
    ]) }}" class="btn btn-outline-primary mb-4">
        ← Back to Chapters
    </a>

    <div class="mb-4">
        <h2 class="fw-bold">{{ $chapter->title }}</h2>

        <p class="text-muted">
            {{ $chapter->classSubject->academicClass->name }}
            · {{ $chapter->classSubject->subject->name }}
        </p>

        <p>{{ $chapter->description }}</p>
    </div>

    <h4 class="fw-bold mb-4">Available Lessons</h4>

    <div class="row g-3">

        @forelse($chapter->lessons as $lesson)

            <div class="col-md-6 col-lg-4">

                <div class="card lesson-card h-100">
                    <div class="card-body p-4">

                        <h5 class="fw-bold">
                            Lesson {{ $lesson->lesson_number }}
                        </h5>

                        <h6>{{ $lesson->title }}</h6>

                        <p class="text-muted">
                            {{ $lesson->description }}
                        </p>

                        <p class="small text-muted">
                            <i class="bi bi-clock"></i>
                            {{ $lesson->estimated_minutes }} minutes
                        </p>

                        <a href="{{ route('student.lessons.show', [
    'lessonId' => $lesson->id
]) }}" class="btn btn-primary w-100">
    Start Lesson →
</a>

                    </div>
                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-info">
                    No published lessons available yet.
                </div>
            </div>

        @endforelse

    </div>

</div>

</body>
</html>
