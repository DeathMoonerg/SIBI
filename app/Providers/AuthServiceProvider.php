<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Attendance;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Attendance Gates
        Gate::define('view-attendance', function (User $user, Attendance $attendance) {
            if ($user->role === 'admin') {
                return true;
            }
            if ($user->role === 'teacher') {
                return $attendance->teacher_id === $user->id;
            }
            if ($user->role === 'parent') {
                return $user->children->pluck('id')->contains($attendance->student_id);
            }
            return false;
        });

        Gate::define('update-attendance', function (User $user, Attendance $attendance) {
            if ($user->role === 'admin') {
                return true;
            }
            if ($user->role === 'teacher') {
                return $attendance->teacher_id === $user->id;
            }
            return false;
        });

        Gate::define('delete-attendance', function (User $user, Attendance $attendance) {
            if ($user->role === 'admin') {
                return true;
            }
            if ($user->role === 'teacher') {
                return $attendance->teacher_id === $user->id;
            }
            return false;
        });
    }
} 
 
 