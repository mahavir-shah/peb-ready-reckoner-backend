<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DeshboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\WebConfigController;

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

});
