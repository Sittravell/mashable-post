<?php

use App\Http\Controllers\PostController;
use App\Http\Middleware\AuthenticateParser;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostController::class, 'index']);
Route::get('/test', function (){
    return 'lol';
});
Route::middleware(AuthenticateParser::class)->group(function () {
    Route::post('/posts', [PostController::class, 'store']);
});
