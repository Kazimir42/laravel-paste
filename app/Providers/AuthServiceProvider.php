<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use function Symfony\Component\Translation\t;

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

        Gate::define('edit-paste', function ($user, $paste) {
            return $user->id == $paste->user_id;
        });

        Gate::define('delete-paste', function ($user, $paste) {
            return $user->id == $paste->user_id;
        });

        Gate::define('view-paste', function (?User $user, $paste) {

            if ($paste->status == 'public' || $paste->status == 'not_listed') {
                return true;
            } else {
                if ($user != null && $user->id == $paste->user_id) {
                    return true;
                } else {
                    return false;
                }
            }

        });
    }
}
