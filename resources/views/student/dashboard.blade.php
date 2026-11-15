
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Smart Teacher - Student Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f4f7fb;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #102a49;
        }

        .main-container {
            padding: 35px 0;
        }

        .welcome-card {
            background: linear-gradient(120deg, #102a49, #2363a5);
            color: white;
            border-radius: 15px;
            padding: 30px;
        }

        .class-card, .subject-card {
            border: 1px solid #e5eaf0;
            border-radius: 12px;
            transition: .2s;
            background: white;
        }

        .class-card:hover, .subject-card:hover {
            border-color: #348fe2;
            transform: translateY(-3px);
        }

        .selected-class {
            border: 2px solid #348fe2;
            background: #eef6ff;
        }

        .subject-icon {
            font-size: 30px;
            color: #348fe2;
        }

        .section-title {
            color: #102a49;
            font-weight: 700;
        }
        .subject-link {
    display: block;
    height: 100%;
    text-decoration: none;
    color: inherit;
}

.subject-link:hover {
    color: inherit;
}

.subject-card {
    cursor: pointer;
}
    </style>
</head>

<body>

<nav class="navbar navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('student.dashboard') }}">
            AI Smart Teacher
        </a>

        <div class="d-flex align-items-center gap-3">
            <span class="text-white">
                {{ $student->name }}
            </span>

            <form action="{{ route('student.logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light btn-sm">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container main-container">

    <div class="welcome-card mb-5">
        <h2>Welcome, {{ $student->name }}! 👋</h2>
        <p class="mb-0">
            Your learning journey starts here. Choose your class and explore your subjects.
        </p>
    </div>

    {{-- Class Selection --}}
    <h4 class="section-title mb-3">1. Select Your Class</h4>

    <div class="row g-3 mb-5">

        @forelse($classes as $class)

            <div class="col-6 col-md-4 col-lg">
                <a href="{{ route('student.dashboard', ['class_id' => $class->id]) }}"
                   class="text-decoration-none text-dark">

                    <div class="card class-card h-100 text-center p-3
                        {{ $selectedClass && $selectedClass->id == $class->id ? 'selected-class' : '' }}">

                        <h2 class="text-primary mb-1">
                            {{ $class->grade_number }}
                        </h2>

                        <h6 class="mb-0">{{ $class->name }}</h6>

                    </div>
                </a>
            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-warning">
                    No active classes available.
                </div>
            </div>

        @endforelse

    </div>

    
{{-- Subject Selection --}}
@if($selectedClass)

    <h4 class="section-title mb-3">
        2. Subjects for {{ $selectedClass->name }}
    </h4>

    <div class="row g-3">

        @forelse($selectedClass->classSubjects as $classSubject)

            @if($classSubject->subject && $classSubject->subject->is_active)

                @php
                    $subject = $classSubject->subject;

                    $icons = [
                        'mathematics' => '🔢',
                        'english' => '📘',
                        'hindi' => '📖',
                        'evs' => '🌍'
                    ];

                    $icon = $icons[strtolower($subject->slug)] ?? '📚';
                @endphp

                <div class="col-6 col-md-3">

                    <a href="{{ route('student.subjects.chapters', [
                        'classSubjectId' => $classSubject->id
                    ]) }}"
                       class="subject-link">

                        <div class="card subject-card h-100 p-3 text-center">

                            <div class="subject-icon mb-2">
                                {{ $icon }}
                            </div>

                            <h5>{{ $subject->name }}</h5>

                            <p class="text-muted small mb-0">
                                Start learning
                            </p>

                        </div>

                    </a>

                </div>

            @endif

        @empty

            <div class="col-12">
                <div class="alert alert-info">
                    No subjects assigned to this class yet.
                </div>
            </div>

        @endforelse

    </div>

@endif


    <div class="mt-5 text-center text-muted">
        <small>© {{ date('Y') }} AI Smart Teacher. Learn, Explore and Grow.</small>
    </div>

</div>

</body>
</html>
