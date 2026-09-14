<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\ContactMessage;
use App\Models\PlanCategory;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
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
        View::composer('admin.layouts.app', function ($view) {
            if (Schema::hasTable('contact_messages') && Schema::hasTable('admin_notifications')) {
                $unreadContactsCount = ContactMessage::where('status', 'new')->count();
                $unreadNotificationsCount = AdminNotification::where('is_read', false)->count();
                $recentAdminNotifications = AdminNotification::orderBy('created_at', 'desc')->take(5)->get();

                $view->with([
                    'unreadContactsCount' => $unreadContactsCount,
                    'unreadNotificationsCount' => $unreadNotificationsCount,
                    'recentAdminNotifications' => $recentAdminNotifications,
                ]);
            } else {
                $view->with([
                    'unreadContactsCount' => 0,
                    'unreadNotificationsCount' => 0,
                    'recentAdminNotifications' => collect(),
                ]);
            }
        });

        View::composer('layout.website', function ($view) {
            if (Schema::hasTable('site_settings') && Schema::hasTable('plan_categories')) {
                $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
                $categories = PlanCategory::where('is_active', true)->orderBy('sort_order')->get();

                $view->with([
                    'settings' => $settings,
                    'categories' => $categories,
                ]);
            } else {
                $view->with([
                    'settings' => [],
                    'categories' => collect(),
                ]);
            }
        });
    }
}
