<?php

namespace App\Providers;

use App\Models\Project;
use App\Policies\ProjectPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    protected $policies = [
        // Adicione esta linha:
        Project::class => ProjectPolicy::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
