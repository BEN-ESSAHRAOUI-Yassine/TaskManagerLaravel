<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\User;
use App\Policies\TaskPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $policies = [
        Task::class => TaskPolicy::class,
        ];
    public function register(): void
    {
        

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
