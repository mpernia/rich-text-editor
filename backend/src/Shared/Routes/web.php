<?php

use Illuminate\Support\Facades\Route;
use Src\Infrastructure\Controllers\OpenApi\DocsController;

Route::redirect('/', '/api', 301);

Route::group(['as' => 'l5-swagger.default.api.docs'], function () {
    Route::group(['prefix' => 'docs'], function () {
        Route::get('/asset/{asset}', [DocsController::class, 'asset'])->name('.asset');
        Route::get('/oauth2-callback', [DocsController::class, 'oauth2Callback'])->name('.oauth2_callback');
    });
    Route::get('/docs.json', [DocsController::class, 'docs'])->name('.json');
    Route::get('/docs/redoc', [DocsController::class, 'redoc'])->name('.redoc');
    Route::get('/docs/swagger', [DocsController::class, 'swagger'])->name('.swagger');
});

