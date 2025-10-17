<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApiController;

Route::get('/', [HomeController::class, 'index']);


Route::get('/hello', [ApiController::class, 'hello']);
Route::get('/add', [ApiController::class, 'add']);

