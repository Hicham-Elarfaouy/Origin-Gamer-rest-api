<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('forgot', 'forgot_password');
    Route::post('reset-password', 'reset_password');
    Route::get('/reset-password/{token}', function(string $token){return $token;})->name('password.reset');
});

Route::controller(UserController::class)->prefix('user')->group(function (){
    Route::match(['put', 'patch'],"/update_pass", "update_password");
    Route::match(['put', 'patch'],"", "update");
    Route::delete("", "destroy");
});

Route::apiResource("category", CategoryController::class);
Route::apiResource("product", ProductController::class);
