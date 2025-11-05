<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\UnitController;
use App\Http\Controllers\admin\SupplierController;
use App\Http\Controllers\admin\SalesManController;
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





// Admin Dashboard Routes
Route::get('/admin/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
// category Routes
Route::resource('/admin/category',CategoryController::class)->names('admin.category');
Route::resource('/admin/sub-category',SubCategoryController::class)->names('admin.sub_category');
Route::resource('/admin/product',ProductController::class)->names('admin.product');
Route::resource('/admin/unit',UnitController::class)->names('admin.unit');
Route::resource('/admin/supplier',SupplierController::class)->names('admin.supplier');
Route::resource('/admin/sales-man',SalesManController::class)->names('admin.sales_man');
