<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('vendor.pagination.bootstrap-4');

        View::composer('*', function ($view) {
            $user = Auth::user();
            $unRead = 0;
            if ($user) {
                $unRead = Notification::with('news')
                    ->where('user_id', $user->id)
                    ->where('is_read', false)->count();
            }
            $view->with('notificationCount', $unRead);
        });
    }
}
