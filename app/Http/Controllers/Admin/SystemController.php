<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;

class SystemController extends Controller
{
    //
    /**
     * Clear application cache, views, route caches, and ensure storage link.
     */
    public function refresh(): RedirectResponse
    {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');

        try {
            Artisan::call('storage:link');
        } catch (\Throwable $e) {
            // Storage link already exists or platform specific
        }

        return redirect()->back()->with('success', 'System caches cleared, views recompiled, and storage linked successfully!');
    }
}
