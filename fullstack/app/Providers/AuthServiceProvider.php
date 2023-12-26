<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Comment;
use App\Models\Conclusion;
use App\Models\Dataset;
use App\Models\ElectreOne;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Policies\CommentPolicy;
use App\Policies\ConclusionPolicy;
use App\Policies\DatasetPolicy;
use App\Policies\ElectreOnePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\ProjectUserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Conclusion::class => ConclusionPolicy::class,
        Dataset::class => DatasetPolicy::class,
        ElectreOne::class => ElectreOnePolicy::class,
        ProjectUser::class => ProjectUserPolicy::class,
        Comment::class => CommentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
