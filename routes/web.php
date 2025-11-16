<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
| Web Routes
*/

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// API test
Route::get('/hello', [ApiController::class, 'hello']);
Route::get('/add', [ApiController::class, 'add']);

// ======= USER AUTH =======

// Hiển thị form đăng nhập
Route::get('/login', [UserController::class, 'showLogin'])->name('login.show');
Route::post('/login', [UserController::class, 'login'])->name('login.post');

// Đăng ký
Route::get('/register', [UserController::class, 'showRegister'])->name('register.show');
Route::post('/register', [UserController::class, 'register'])->name('register.post');

// Đăng xuất
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// ======= USER ROUTES =======

// Trang cá nhân
Route::get('/user/profile', [UserController::class, 'showUserProfile'])->name('main.info');
Route::get('/user/edit', [UserController::class, 'showUserProfileEdit'])->name('main.edit');
Route::put('/user/profile', [UserController::class, 'updateUserProfile'])->name('user.profile.update');

// Tour của user
Route::get('/user/tours', [UserController::class, 'showUserTours'])->name('user.tours');
Route::post('/user/tour/pay/{id}', [UserController::class, 'payTour'])->name('user.tour.pay');
Route::post('/user/tour/{id}/cancel', [UserController::class, 'cancelTour'])->name('user.tour.cancel');

// Chi tiết tour
Route::get('/tours/{id}', [HomeController::class, 'show'])->name('tours.show');
Route::post('/tour/dat', [HomeController::class, 'datTour'])->name('tour.dat');

// ======= ADMIN ROUTES =======
Route::prefix('admin')->group(function () {

    // Dashboard
    Route::view('dashboard', 'admin.dashboard')->name('admin.dashboard');

    // Thành viên nhóm
    Route::get('members', [AdminController::class, 'listMembers'])->name('admin.members');

    // ==== User ====
    Route::get('users', [AdminController::class, 'listUsers'])->name('admin.users');
    Route::get('edit/{email}', [AdminController::class, 'editUser'])->name('admin.editUser');
    Route::put('update/{email}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
    Route::delete('delete/{email}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');

    // ==== Nhà tổ chức ====
    Route::get('nhatochuc', [AdminController::class, 'listNhaToChuc'])->name('admin.nhatc');
    Route::get('nhatochuc/create', [AdminController::class, 'createNhaToChuc'])->name('admin.createNhatc');
    Route::post('nhatochuc/store', [AdminController::class, 'storeNhaToChuc'])->name('admin.nhatc.store');
    Route::get('nhatochuc/{id}/edit', [AdminController::class, 'editNhaToChuc'])->name('admin.editNhatc');
    Route::put('nhatochuc/{id}', [AdminController::class, 'updateNhaToChuc'])->name('admin.updateNhatc');
    Route::delete('nhatochuc/{id}', [AdminController::class, 'deleteNhaToChuc'])->name('admin.deleteNhatc');

    // ==== Tour ====
    Route::get('tours', [AdminController::class, 'listTours'])->name('admin.tours');
    Route::get('tour/create', [AdminController::class, 'createTour'])->name('admin.createTour');
    Route::post('tour/store', [AdminController::class, 'storeTour'])->name('admin.tour.store');
    Route::get('tour/{id}/edit', [AdminController::class, 'editTour'])->name('admin.editTour');
    Route::put('tour/update/{id}', [AdminController::class, 'updateTour'])->name('admin.tour.update');
    Route::delete('tours/{id}', [AdminController::class, 'deleteTour'])->name('admin.deleteTour');

    // ==== Địa điểm ====
    Route::get('diadiem', [AdminController::class, 'listDiaDiem'])->name('admin.diadiem');
    Route::get('diadiem/create', [AdminController::class, 'createDiaDiem'])->name('admin.createDiaDiem');
    Route::post('diadiem/store', [AdminController::class, 'storeDiaDiem'])->name('admin.storeDiaDiem');
    Route::get('diadiem/{id}/edit', [AdminController::class, 'editDiaDiem'])->name('admin.editDiaDiem');
    Route::put('diadiem/update/{id}', [AdminController::class, 'updateDiaDiem'])->name('admin.updateDiaDiem');
    Route::delete('diadiem/{id}', [AdminController::class, 'deleteDiaDiem'])->name('admin.deleteDiaDiem');

    // ==== Đặt tour ====
    Route::get('dattour', [AdminController::class, 'listDatTour'])->name('admin.dattour');
    Route::delete('dattour/{id}', [AdminController::class, 'deleteDatTour'])->name('admin.deleteDatTour');

    // ==== Hóa đơn ====
    Route::get('hoadon', [AdminController::class, 'listHoaDon'])->name('admin.hoadon');
    Route::delete('hoadon/{id}', [AdminController::class, 'deleteHoaDon'])->name('admin.deleteHoaDon');

    // ==== Đánh giá ====
    Route::get('danhgia', [AdminController::class, 'listDanhGia'])->name('admin.danhgia');
    Route::delete('danhgia/{id}', [AdminController::class, 'deleteDanhGia'])->name('admin.deleteDanhGia');

    // ==== Thống kê ====
    Route::get('statistical', [AdminController::class, 'showStatistical'])->name('admin.statistical');

});

Route::get('/user/payments', [UserController::class, 'payments'])->name('main.cart');

// Search
Route::get('/search', [HomeController::class, 'search'])->name('home.search');
