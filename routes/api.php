<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\EstimateController;

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
Route::get('get-company-name', [OtpController::class, 'getCompanyName']);
Route::get('get-designatione', [OtpController::class, 'getdesignation']);
Route::get('export-estimate/{id}', [EstimateController::class, 'exportEstimate']);

Route::group(['middleware' => ['jwt.verify']], function() {

    //logout
    Route::post('logout', [OtpController::class, 'logout']);

    //User
    
    Route::get('get-state-cities', [UserController::class, 'getStateCities']);
    Route::get('get-profile', [UserController::class, 'getProfile']);
    Route::post('update-profile', [UserController::class, 'updateProfile']);
    Route::get('get-user-rate-material', [UserController::class, 'getUserRateMaterial']);
    Route::post('user-rate-material', [UserController::class, 'userRateMaterial']);
    Route::post('update-user-companydetails', [UserController::class, 'updateCompanyDetails']);
    

    //News
    Route::get('get-news', [NewsController::class, 'getNews']);

    //Payment
    Route::get('get-plan-name', [PaymentController::class, 'getPlanName']);
    Route::get('get-payment-history', [PaymentController::class, 'getPaymentHistory']);

    //Estimate
    Route::post('create-estimate', [EstimateController::class, 'createEstimate']);
    Route::get('get-estimate-history', [EstimateController::class, 'getEstimateHistory']);
    Route::get('get-estimate-history-details', [EstimateController::class, 'getEstimateHistoryDetails']);

});