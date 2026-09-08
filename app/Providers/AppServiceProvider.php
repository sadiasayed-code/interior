<?php

namespace App\Providers;

use App\Models\Project;
use Illuminate\Support\Facades\View;
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


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
        |----------------------------------------------------------------------
        | ADMIN SIDEBAR - PENDING PROJECT REQUEST COUNT
        |----------------------------------------------------------------------
        |
        | Count only active pending project requests.
        |
        | Cancelled projects are excluded.
        |
        */

        View::composer(
            'backend.layouts.admin',
            function ($view) {

                $pendingProjectRequests = Project::query()

                    ->where(
                        'approval_status',
                        'pending'
                    )

                    ->whereNotIn(
                        'status',
                        [
                            'cancelled',
                            'canceled',
                        ]
                    )

                    ->count();


                $view->with(
                    'pendingProjectRequests',
                    $pendingProjectRequests
                );
            }
        );
    }
}