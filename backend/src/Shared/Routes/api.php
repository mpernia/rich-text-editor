<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\Infrastructure\Controllers\API\V1\{
    HealthCheckController,
    PdfDownloaderController,
    PostController,
    StatusController,
    UserController
};

Route::any('/', function (Request $request) {
    return response()->json(['status' => 'ok']);
});

Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {
    Route::get('/health', HealthCheckController::class);
    Route::apiResource('users', UserController::class)->only(['index', 'show']);
    Route::apiResource('statuses', StatusController::class)->only(['index', 'show']);
    Route::apiResource('posts', PostController::class);
    Route::get('/posts/{post}/pdf', PdfDownloaderController::class)->name('posts.pdf');
});
