<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public Website
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin Authentication
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Panel
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Overview Dashboard
    Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Hosting Plans
    // Hosting Plans & Custom Categories
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
    Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');
    Route::patch('/plans/{plan}/toggle', [PlanController::class, 'toggleStatus'])->name('plans.toggle');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Domain TLDs
    Route::get('/domains', [DomainController::class, 'index'])->name('domains.index');
    Route::post('/domains', [DomainController::class, 'store'])->name('domains.store');
    Route::put('/domains/{domain}', [DomainController::class, 'update'])->name('domains.update');
    Route::delete('/domains/{domain}', [DomainController::class, 'destroy'])->name('domains.destroy');
    Route::patch('/domains/{domain}/toggle', [DomainController::class, 'toggleStatus'])->name('domains.toggle');

    // Core Features
    Route::get('/features', [FeatureController::class, 'index'])->name('features.index');
    Route::post('/features', [FeatureController::class, 'store'])->name('features.store');
    Route::put('/features/{feature}', [FeatureController::class, 'update'])->name('features.update');
    Route::delete('/features/{feature}', [FeatureController::class, 'destroy'])->name('features.destroy');
    Route::patch('/features/{feature}/toggle', [FeatureController::class, 'toggleStatus'])->name('features.toggle');

    // Client Reviews / Testimonials
    Route::get('/testimonials', [ReviewController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials', [ReviewController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{testimonial}', [ReviewController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [ReviewController::class, 'destroy'])->name('testimonials.destroy');
    Route::patch('/testimonials/{testimonial}/toggle', [ReviewController::class, 'toggleStatus'])->name('testimonials.toggle');

    // FAQs Accordion
    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
    Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');
    Route::patch('/faqs/{faq}/toggle', [FaqController::class, 'toggleStatus'])->name('faqs.toggle');

    // Site & Promo Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // System Cache Refresh & Storage Link
    Route::post('/system/refresh', [SystemController::class, 'refresh'])->name('system.refresh');

    // Visitor Tracking & Analytics
    Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index');

    // Admin Profile & Security
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Client-side Analytics Beacon (Public POST)
Route::post('/api/track-visitor', [VisitorController::class, 'beacon'])->name('api.track-visitor');
