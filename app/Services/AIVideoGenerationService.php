<?php

namespace App\Services;

use App\Models\AIVideoGeneration;
use App\Models\Lesson;
use Illuminate\Support\Collection;

class AIVideoGenerationService
{
    public function ensureForLesson(int $lessonId): void
    {
        $lesson = Lesson::with('contents')->find($lessonId);

        if (!$lesson || !$lesson->is_published) {
            return;
        }

        $availableLanguages = $lesson->contents
            ->pluck('language')
            ->unique()
            ->values();

        // Both language versions must exist.
        if (!$availableLanguages->contains('en') ||
            !$availableLanguages->contains('hi')) {
            return;
        }

        foreach (['en', 'hi'] as $language) {
            AIVideoGeneration::firstOrCreate(
                [
                    'lesson_id' => $lesson->id,
                    'language' => $language,
                ],
                [
                    'video_style' => 'mixed',
                    'status' => 'pending',
                ]
            );
        }
    }
}
