<?php

use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\PostController;
use App\Http\Controllers\Frontend\User\ProfileController;
use Faker\Guesser\Name;
use Tabuna\Breadcrumbs\Trail;

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the user has not confirmed their email
 */
Route::group(['as' => 'user.', 'middleware' => ['auth', 'password.expires', config('boilerplate.access.middleware.verified')]], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->middleware('is_user')
        ->name('dashboard')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.index')
                ->push(__('Dashboard'), route('frontend.user.dashboard'));
        });

    Route::get('account', [AccountController::class, 'index'])
        ->name('account')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.index')
                ->push(__('My Account'), route('frontend.user.account'));
        });

    Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');


});

Route::group(['prefix' => 'post','as' => 'post.',  'middleware' => ['auth', 'password.expires', config('boilerplate.access.middleware.verified')]], function() {
    Route::get('create', [PostController::class, 'create'])
        ->middleware('is_user')
        ->name('create');
    Route::post('/', [PostController::class, 'store'])
        ->name('store');
});
