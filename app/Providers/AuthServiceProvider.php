<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * permissions
         */
        Gate::define('view-task', function (User $user, Task $task) {
            return $user->id == $task->user->id;
        });
        Gate::define('view-all', function (User $user) {
            return $user->name == 'amirhossein';
        });
        Gate::define('delete-admin', function (User $auth, User $user) {
            if ($user->role == 'user' || $auth->role == 'super-admin' && $auth->id != $user->id) return true;
        });

        /**
         * roles
         */
        Gate::define('admin', function (User $user) {
            return str_contains($user->role, 'admin');
        });
    }
}
