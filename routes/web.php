<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ImageUploadController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SalesManController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\SupplierController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\UnitController;
use App\Http\Controllers\front\HomeController;

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


Route::get('/',[HomeController::class,'home'])->name('home');
Route::get('/contact',[HomeController::class,'contact'])->name('contact');
Route::get('/user-registration',[HomeController::class,'userRegistration'])->name('user.registration');
Route::post('/user-registration-store',[HomeController::class,'userRegistrationStore'])->name('user.registration_store');
Route::get('/user-login',[HomeController::class,'userLogin'])->name('user_login');





// Admin Dashboard Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // image upload
    Route::post('/upload-image', [ImageUploadController::class, 'store'])->name('upload_image');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource routes
    Route::resource('/category', CategoryController::class)->names('category');
    Route::resource('/sub-category', SubCategoryController::class)->names('sub_category');
    Route::resource('/product', ProductController::class)->names('product');
    Route::resource('/unit', UnitController::class)->names('unit');
    Route::resource('/supplier', SupplierController::class)->names('supplier');
    Route::resource('/sales-man', SalesManController::class)->names('sales_man');
    Route::resource('/colors', ColorController::class)->names('colors');
    Route::resource('/sizes', SizeController::class)->names('sizes');
});
