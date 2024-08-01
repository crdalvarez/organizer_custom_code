<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Client;
use App\Models\Team;
use App\Models\Stage;
use App\Policies\TaskPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\ClientPolicy;
use App\Policies\TeamPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        
        Task::class => TaskPolicy::class,
        Project::class => ProjectPolicy::class,
        Stage::class => ProjectPolicy::class,  // Stage uses ProjectPolicy for authorization, as Stages belongs to a Project, it inherit Project Policies. 
        Client::class => ClientPolicy::class,
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::resource('profile', ProfilePolicy::class);
    }
}
