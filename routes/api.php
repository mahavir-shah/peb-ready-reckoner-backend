<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NewsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('send-otp', [OtpController::class, 'SendOtp']);
Route::post('login', [OtpController::class, 'login']);
Route::post('register', [OtpController::class, 'register']);
Route::post('get-company-name', [OtpController::class, 'getCompanyName']);
Route::post('get-designatione', [OtpController::class, 'getdesignation']);

Route::group(['middleware' => ['jwt.verify']], function() {

    //logout
    Route::post('logout', [OtpController::class, 'logout']);

    //User
    Route::post('update-profile', [UserController::class, 'updateProfile']);

    //News
    Route::get('get-news', [NewsController::class, 'getNews']);
});