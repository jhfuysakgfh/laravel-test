<?php

namespace App\Observers;

use App\Models\Lesson;
use App\Services\AIVideoGenerationService;

class LessonObserver
{
    public function saved(Lesson $lesson): void
    {
        app(AIVideoGenerationService::class)
            ->ensureForLesson($lesson->id);
    }
}
