<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\SubCategoryController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




// Admin Dashboard Routes
Route::get('/admin/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
// category Routes
Route::resource('/admin/category',CategoryController::class)->names('admin.category');
Route::resource('/admin/sub-category',SubCategoryController::class)->names('admin.sub_category');
