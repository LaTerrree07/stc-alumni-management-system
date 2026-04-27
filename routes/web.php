<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniProfileController;
use App\Http\Controllers\Admin\AlumniProfileController as AdminAlumniProfileController;
use App\Http\Controllers\AlumniNetworkController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventFundController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('alumni.dashboard');
    }

    return view('welcome');
})->name('landing');

Route::get('/dashboard', [DashboardController::class, 'redirect'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes from Laravel Breeze
|--------------------------------------------------------------------------
| Keep these because Breeze navigation uses route('profile.edit').
*/
Route::middleware('auth')->group(function () {
    Route::get('/account/settings', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/account/settings', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/account/settings', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
       Route::get('/dashboard', [DashboardController::class, 'admin'])
    ->name('dashboard');

        Route::get('/alumni-profiles', [AdminAlumniProfileController::class, 'index'])
            ->name('alumni-profiles.index');

        Route::get('/alumni-profiles/{user}', [AdminAlumniProfileController::class, 'show'])
            ->name('alumni-profiles.show');

        Route::get('/alumni-network', [AlumniNetworkController::class, 'index'])
            ->name('alumni-network.index');

        Route::get('/alumni-network/{user}', [AlumniNetworkController::class, 'show'])
            ->name('alumni-network.show');

        Route::resource('job-posts', JobPostController::class);

Route::patch('/job-posts/{jobPost}/approve', [JobPostController::class, 'approve'])
    ->name('job-posts.approve');

Route::patch('/job-posts/{jobPost}/reject', [JobPostController::class, 'reject'])
    ->name('job-posts.reject');

Route::patch('/job-posts/{jobPost}/archive', [JobPostController::class, 'archive'])
    ->name('job-posts.archive');

Route::resource('events', EventController::class);

Route::patch('/events/{event}/approve', [EventController::class, 'approve'])
    ->name('events.approve');

Route::patch('/events/{event}/reject', [EventController::class, 'reject'])
    ->name('events.reject');

Route::patch('/events/{event}/complete', [EventController::class, 'complete'])
    ->name('events.complete');

Route::patch('/events/{event}/cancel', [EventController::class, 'cancel'])
    ->name('events.cancel');

Route::patch('/events/{event}/archive', [EventController::class, 'archive'])
    ->name('events.archive');

Route::get('/event-funds', [EventFundController::class, 'index'])
    ->name('event-funds.index');

Route::post('/event-funds', [EventFundController::class, 'store'])
    ->name('event-funds.store');

Route::put('/event-funds/{eventFund}', [EventFundController::class, 'update'])
    ->name('event-funds.update');

Route::resource('donations', DonationController::class);

Route::patch('/donations/{donation}/verify', [DonationController::class, 'verify'])
    ->name('donations.verify');

Route::patch('/donations/{donation}/reject', [DonationController::class, 'reject'])
    ->name('donations.reject');

Route::patch('/donations/{donation}/archive', [DonationController::class, 'archive'])
    ->name('donations.archive');

Route::resource('announcements', AnnouncementController::class);

Route::patch('/announcements/{announcement}/publish', [AnnouncementController::class, 'publish'])
    ->name('announcements.publish');

Route::patch('/announcements/{announcement}/archive', [AnnouncementController::class, 'archive'])
    ->name('announcements.archive');

Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications.index');

Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
    ->name('notifications.read');

Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
    ->name('notifications.read-all');
    }); 

/*
|--------------------------------------------------------------------------
| Alumni Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:alumni'])
    ->prefix('alumni')
    ->name('alumni.')
    ->group(function () {
       Route::get('/dashboard', [DashboardController::class, 'alumni'])
    ->name('dashboard');

        Route::get('/profile', [AlumniProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [AlumniProfileController::class, 'update'])
            ->name('profile.update');

        Route::get('/alumni-network', [AlumniNetworkController::class, 'index'])
            ->name('alumni-network.index');

        Route::get('/alumni-network/{user}', [AlumniNetworkController::class, 'show'])
            ->name('alumni-network.show');

        Route::resource('job-posts', JobPostController::class)
    ->except(['destroy']);    

    Route::resource('events', EventController::class)
    ->except(['destroy']);

    Route::get('/event-funds', [EventFundController::class, 'index'])
    ->name('event-funds.index');

    Route::resource('donations', DonationController::class)
    ->except(['destroy']);

    Route::resource('announcements', AnnouncementController::class)
    ->only(['index', 'show']);

    Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications.index');

Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
    ->name('notifications.read');

Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
    ->name('notifications.read-all');
    });
require __DIR__.'/auth.php';