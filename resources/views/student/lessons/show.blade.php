
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lesson->title }} - AI Smart Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f7fb;
        }
        .navbar {
            background: #102a49;
        }
        .learning-card {
            background: #fff;
            border-radius: 14px;
            padding: 28px;
            border: 1px solid #e5eaf0;
        }
        .learning-area {
            min-height: 250px;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            background: #fafcff;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark px-4 py-3">
    <div class="container">
        <span class="navbar-brand fw-bold">AI Smart Teacher</span>
        <span class="text-white">Student Learning</span>
    </div>
</nav>

<div class="container py-5">

    <a href="{{ route('student.chapters.lessons', [
        'chapterId' => $lesson->chapter_id
    ]) }}" class="btn btn-outline-primary mb-4">
        ← Back to Lessons
    </a>

    <div class="learning-card mb-4">
        <div class="text-muted mb-2">
            Class {{ $lesson->chapter->classSubject->academicClass->grade_number ?? '' }}
            · {{ $lesson->chapter->classSubject->subject->name ?? '' }}
        </div>

        <h1 class="fw-bold">{{ $lesson->title }}</h1>

        <p class="text-muted mb-0">
            {{ $lesson->description }}
        </p>

        <hr>

        <span class="badge bg-primary">
            Lesson {{ $lesson->lesson_number }}
        </span>

        <span class="badge bg-secondary">
            {{ $lesson->estimated_minutes }} Minutes
        </span>
    </div>

    
@php
    $englishContent = $lesson->contents->firstWhere('language', 'en');
    $hindiContent = $lesson->contents->firstWhere('language', 'hi');
@endphp

<div class="learning-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <h3 class="fw-bold mb-2">Let's Start Learning!</h3>

        <div class="btn-group">
            <button type="button"
                    class="btn btn-primary language-btn"
                    data-language="en">
                English
            </button>

            <button type="button"
                    class="btn btn-outline-primary language-btn"
                    data-language="hi">
                हिंदी
            </button>
        </div>
    </div>

    @foreach(['en' => $englishContent, 'hi' => $hindiContent] as $language => $content)

        <div class="language-content"
             id="content-{{ $language }}"
             style="{{ $language === 'en' ? '' : 'display:none;' }}">

            @if($content)

                <h4 class="fw-bold mb-3">
                    {{ $language === 'en' ? 'Lesson Explanation' : 'पाठ की व्याख्या' }}
                </h4>

                <div class="learning-area text-start mb-4">
                    <p class="fs-5 mb-0" style="white-space: pre-line;">
                        {{ $content->content }}
                    </p>
                </div>

                <h4 class="fw-bold mb-3">
                    {{ $language === 'en' ? 'Learning Objectives' : 'सीखने के उद्देश्य' }}
                </h4>

                <div class="learning-area text-start mb-4">
                    <p class="mb-0" style="white-space: pre-line;">
                        {{ $content->learning_objectives }}
                    </p>
                </div>

                <h4 class="fw-bold mb-3">
                    {{ $language === 'en' ? 'Key Points' : 'मुख्य बिंदु' }}
                </h4>

                <div class="learning-area text-start">
                    <p class="mb-0" style="white-space: pre-line;">
                        {{ $content->key_points }}
                    </p>
                </div>

            @else
                <div class="alert alert-warning">
                    {{ $language === 'en'
                        ? 'English content is not available yet.'
                        : 'हिंदी सामग्री अभी उपलब्ध नहीं है।' }}
                </div>
            @endif

        </div>

    @endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const buttons = document.querySelectorAll('.language-btn');
    const contents = document.querySelectorAll('.language-content');

    buttons.forEach(button => {
        button.addEventListener('click', function () {

            const selectedLanguage = this.dataset.language;

            buttons.forEach(btn => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
            });

            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary');

            contents.forEach(content => {
                content.style.display =
                    content.id === 'content-' + selectedLanguage
                        ? 'block'
                        : 'none';
            });

        });
    });

});
</script>


</div>

</body>
</html>
