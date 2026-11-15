<?php

namespace App\Observers;

use App\Models\LessonContent;
use App\Services\AIVideoGenerationService;

class LessonContentObserver
{
    public function saved(LessonContent $lessonContent): void
    {
        app(AIVideoGenerationService::class)
            ->ensureForLesson($lessonContent->lesson_id);
    }
}
