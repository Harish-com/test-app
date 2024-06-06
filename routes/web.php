<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::group(['middleware' => ['auth', 'verified']], function () {

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/product-list', [HomeController::class, 'productList'])->name('product-list');

//categories 
Route::resource('categories', CategoriesController::class);
Route::post('/cate/update/{id}', [CategoriesController::class, 'updates'])->name('cate.updates');

//product
Route::resource('product', ProductController::class);
Route::post('/prt/update/{id}', [ProductController::class, 'update'])->name('prt.update');

});