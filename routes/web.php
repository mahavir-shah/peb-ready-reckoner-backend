<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DeshboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\WebConfigController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\WebhookReceiveController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


 
// Route::get('/home/{id}', [App\Http\Controllers\HomeController::class, 'detailPage'])->name('detailPage');
// Route::get('fill-data-pdf', [PDFController::class,'index']);

Route::get('/', [LoginController::class, 'LoginForm'])->name('login'); 
Route::get('/payment/{plan}/{id}', [LoginController::class, 'payment'])->name('paymentDetails');
Route::post('/payment-process', [LoginController::class, 'paymentProcess'])->name('paymentProcess');
Route::post('/login-process', [LoginController::class, 'login'])->name('loginProcess');

Route::group(['middleware' =>['auth']], function () {

    //deshboard
    Route::get('/dashboard', [DeshboardController::class, 'index'])->name('admin.Deshboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    //News
    Route::get('/news', [NewsController::class, 'index'])->name('admin.news');
    Route::post('/news-data', [NewsController::class, 'newsData'])->name('admin.newsData');
    Route::get('/news/add', [NewsController::class, 'add'])->name('admin.newsAdd');
    Route::post('/news-create', [NewsController::class, 'create'])->name('admin.newscreate');
    Route::get('/news/{id}', [NewsController::class, 'edit'])->name('admin.newsEdit');
    Route::post('/delete-news', [NewsController::class, 'deleteNews'])->name('admin.newsdelete');

    //Web Config
    Route::get('/web-config', [WebConfigController::class, 'index'])->name('admin.webConfig');
    Route::post('/webconfig-data', [WebConfigController::class, 'newsData'])->name('admin.webConfigData');
    Route::post('/webconfig-create', [WebConfigController::class, 'create'])->name('admin.webConfigcreate');
    Route::get('/web-config/{id}', [WebConfigController::class, 'edit'])->name('admin.webConfigEdit');

    //Company Name
    Route::get('/company', [CompanyController::class, 'index'])->name('admin.Company');
    Route::post('/company-data', [CompanyController::class, 'companyData'])->name('admin.companyData');
    Route::post('/company-add', [CompanyController::class, 'create'])->name('admin.companyAdd');
    Route::post('/company-delete', [CompanyController::class, 'delete'])->name('admin.companyDelete');
    Route::post('/company-update', [CompanyController::class, 'update'])->name('admin.companyUpdate');
    Route::post('/company-arcade-data', [CompanyController::class, 'companyArcadeData'])->name('admin.companyArcadeData');
    Route::post('/company-restore', [CompanyController::class, 'restore'])->name('admin.companyRestore');

    //Designation
    Route::get('/designation', [DesignationController::class, 'index'])->name('admin.Designation');
    Route::post('/designation-data', [DesignationController::class, 'designationData'])->name('admin.designationData');
    Route::post('/designation-add', [DesignationController::class, 'create'])->name('admin.designationAdd');
    Route::post('/designation-delete', [DesignationController::class, 'delete'])->name('admin.designationDelete');
    Route::post('/designation-update', [DesignationController::class, 'update'])->name('admin.designationUpdate');
    Route::post('/designation-arcade-data', [DesignationController::class, 'designationArcadeData'])->name('admin.designationArcadeData');
    Route::post('/designation-restore', [DesignationController::class, 'restore'])->name('admin.designationRestore');
});


// Webhook testing
Route::get('/purchaseReceive',[WebhookReceiveController::class, 'purchaseReceive']);
Route::get('/ReceiveToken',[WebhookReceiveController::class, 'tokenReceive']);
