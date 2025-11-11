<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index']);


Route::get('/hello', [ApiController::class, 'hello']);
Route::get('/add', [ApiController::class, 'add']);

// Trang mặc định → hiển thị form đăng nhập
Route::get('/', [UserController::class, 'showLogin'])->name('login.show');

// Đăng nhập
Route::get('/login', [UserController::class, 'showLogin'])->name('login.show');
Route::post('/login', [UserController::class, 'login'])->name('login.post');

// Đăng ký
Route::get('/register', [UserController::class, 'showRegister'])->name('register.show');
Route::post('/register', [UserController::class, 'register'])->name('register.post');

// Trang home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Chi tiết tour
Route::get('/tours/{id}', [HomeController::class, 'show'])->name('tours.show');

// Đặt tour
Route::post('/tour/dat', [HomeController::class, 'datTour'])->name('tour.dat');

// Đăng xuất
Route::get('/logout', [UserController::class, 'logout'])->name('logout');