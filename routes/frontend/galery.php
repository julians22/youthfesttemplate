<?php

use App\Http\Controllers\Frontend\GaleryController;
use App\Http\Controllers\Frontend\PostActionController;

Route::group(['prefix' => 'galery', 'as' => 'galery.'], function() {
    Route::get('/', [GaleryController::class, 'index'])
        ->name('index');
    Route::group(['prefix' => '{slug}'], function() {
        Route::get('/', [GaleryController::class, 'show'])
            ->name('show');
    });
    Route::get('/', [GaleryController::class, 'index'])
        ->name('index');

    Route::group(['prefix' => 'action', 'as' => 'action.'], function() {
        Route::group(['prefix' => '{post}'], function() {
            Route::put('like', [PostActionController::class, 'like'])
                ->name('like');
            Route::put('unlike', [PostActionController::class, 'unlike'])
                ->name('unlike');

            Route::put('share', [PostActionController::class, 'share'])
                ->name('share');
            Route::put('testCookie', [PostActionController::class, 'testCookie'])
                ->name('testCookie');
        });
    });
});

