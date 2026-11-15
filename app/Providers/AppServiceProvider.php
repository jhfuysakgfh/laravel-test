<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Lesson;
use App\Models\LessonContent;
use App\Observers\LessonObserver;
use App\Observers\LessonContentObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Lesson::observe(LessonObserver::class);

        LessonContent::observe(LessonContentObserver::class);
    }
}
