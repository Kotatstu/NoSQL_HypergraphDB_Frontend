<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ApiController;

Route::get('/hello', [ApiController::class, 'hello']);
Route::get('/add', [ApiController::class, 'add']);
