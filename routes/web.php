<?php

use \Illuminate\Support\Facades\Route;
use \App\Http\Controllers;
use \App\Http\Middleware;

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


Route::get('/', [Controllers\ProductController::class, 'index'])->name('home');

Route::get('/register', [Controllers\Auth\RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [Controllers\Auth\RegisterController::class, 'register']);

Route::get('/login', [Controllers\Auth\LoginController::class, 'showForm'])->name('login');
Route::post('/login', [Controllers\Auth\LoginController::class, 'login']);
Route::get('/logout', [Controllers\Auth\LoginController::class, 'logout'])->name('logout');


Route::resource('/admin/product', Controllers\Admin\ProductController::class); // управление товарами
Route::resource('/admin/order', Controllers\Admin\OrderController::class); // управление закзазами
Route::post('/admin/order/setStatus', [Controllers\Admin\OrderController::class, 'setStatus']); // изменить статус зазказа

Route::resource('product', Controllers\ProductController::class); // товары



Route::get('/basket', [Controllers\BasketController::class, 'index']); // страница корзины с блоком оформлениия заказа
Route::post('/basket/add', [Controllers\BasketController::class, 'addItem']); // добавить товар в корзину
Route::post('/basket/updateItem', [Controllers\BasketController::class, 'updateItem']); // изменить товар в корзине
Route::post('/basket/deleteItem', [Controllers\BasketController::class, 'deleteItem']); // удалить товар из корзины
Route::get('/basket/getList', [Controllers\BasketController::class, 'getList']);  // получить корзину аяксом

Route::resource('order', Controllers\OrderController::class); // для оформления закзаза аяксом, и страница с успехом оформления