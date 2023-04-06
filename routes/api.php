<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\UserInfoController;
use App\Http\Controllers\Api\Admin\CategoriesController;
use App\Http\Controllers\Api\Admin\ProductsController;
use App\Http\Controllers\Api\Admin\PositionController;
use App\Http\Controllers\Api\Admin\RolesController;

use App\Http\Controllers\Api\Customer\CustomerUserInfoController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// AUTH API - DÀNH CHO NGƯỜI DÙNG.
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/reset-password', [AuthController::class, 'passwordReset']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user-login', [AuthController::class, 'userLogin']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


// ADMIN API
Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'adminLogin']);

    Route::middleware(['isAdmin', 'auth:sanctum'])->group(function () {

        // THÊM SỬA XÓA TÀI KHOẢN.
        Route::prefix('/user')->group(function () {
            Route::get('/all', [UserController::class, 'index']);
            Route::post('/create', [UserController::class, 'create']);
            Route::get('/edit/{id}', [UserController::class, 'edit']);
            Route::post('/update/{id}', [UserController::class, 'update']);
            Route::delete('/delete/{id}', [UserController::class, 'delete']);
        });

        // THÊM SỬA XÓA THÔNG TIN TÀI KHOẢN.
        Route::prefix('/user-info')->group(function () {
            Route::get('/all', [UserInfoController::class, 'index']);
            Route::get('/edit/{user_id}', [UserInfoController::class, 'edit']);
            Route::post('/update/{user_id}', [UserInfoController::class, 'update']);
            Route::delete('/delete/{id}', [UserInfoController::class, 'delete']);
        });

        // THÊM SỬA XÓA DANH MỤC SẢN PHẨM.
        Route::prefix('/categories')->group(function () {
            Route::get('/all', [CategoriesController::class, 'index']);
            Route::post('/create', [CategoriesController::class, 'create']);
            Route::get('/edit/{id}', [CategoriesController::class, 'edit']);
            Route::post('/update/{id}', [CategoriesController::class, 'update']);
            Route::delete('/delete/{id}', [CategoriesController::class, 'delete']);
        });

        // THÊM SỬA XÓA SẢN PHẨM.
        Route::prefix('/product')->group(function () {
            Route::get('/all', [ProductsController::class, 'index']);
            Route::post('/create', [ProductsController::class, 'create']);
            Route::get('/edit/{id}', [ProductsController::class, 'edit']);
            Route::post('/update/{id}', [ProductsController::class, 'update']);
            Route::delete('/delete/{id}', [ProductsController::class, 'delete']);
        });

        // THÊM XÓA CHỨC VỤ.
        Route::prefix('/position')->group(function () {
            Route::get('/all', [PositionController::class, 'index']);
            Route::post('/create', [PositionController::class, 'create']);
            Route::delete('/delete/{id}', [PositionController::class, 'delete']);
        });

        Route::get('role/all', [RolesController::class, 'index']);
    });
});


// CUSTOMER API

// THÊM SỬA THÔNG TIN TÀI KHOẢN CỦA NGƯỜI DÙNG - KHÔNG CÓ QUYỀN XÓA.
Route::prefix('customer')->middleware('auth:sanctum')->group(function () {
    Route::get('/edit/{user_id}', [CustomerUserInfoController::class, 'edit']);
    Route::post('/update/{user_id}', [CustomerUserInfoController::class, 'update']);
});

Route::middleware('isActive')->group(function () {
    // code
});
