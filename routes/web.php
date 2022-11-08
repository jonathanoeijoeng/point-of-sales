<?php

use App\Events\OrderSent;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

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
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::redirect('/', '/login');

Route::middleware([
    'auth:sanctum', config('jetstream.auth_session'), 'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:view dashboard');
    Route::post('/dashboard/add-tofavs', [DashboardController::class, 'addToFavorites'])->name('dashboard.add-to-favs');
    Route::get('/table', [OrderController::class, 'index'])->name('table');
    Route::get('/order', [OrderController::class, 'order'])->name('order');
    Route::post('/add-order', [OrderController::class, 'add'])->name('order.add');
    Route::post('/change-order', [OrderController::class, 'change'])->name('order.change');
    Route::any('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::any('/checkout-success', [OrderController::class, 'checkout_success'])->name('checkout.success');
    Route::post('/note', [OrderController::class, 'note'])->name('order.note');
    Route::get('/kitchen', [OrderController::class, 'kitchen'])->name('kitchen')->middleware('permission:view kitchen');
    Route::post('/sent_to_kitchen', [OrderController::class, 'sent_to_kitchen'])->name('order.sent_to_kitchen');
    Route::post('/process', [OrderController::class, 'process'])->name('order.process');
    Route::post('/done', [OrderController::class, 'done'])->name('order.done');
    Route::get('/invoice', [OrderController::class, 'invoice'])->name('order.invoice')->middleware('permission:view invoice');
    Route::get('/invoice/detail', [OrderController::class, 'invoice_detail'])->name('invoice.detail');
    Route::any('/settings', [SettingController::class, 'index'])->name('settings')->middleware('permission:view settings');
    Route::post('/settings/recommended', [SettingController::class, 'recommended'])->name('recommended');
    Route::post('/settings/favourite', [SettingController::class, 'favourite'])->name('favourite');
    Route::post('/settings/status', [SettingController::class, 'status'])->name('status');
    Route::post('/settings/category', [SettingController::class, 'category'])->name('category');
    Route::post('/settings/upload', [SettingController::class, 'upload'])->name('upload');
    Route::delete('/settings/upload', [SettingController::class, 'deleteUpload'])->name('delete.upload');
    Route::get('/settings/food/create', [SettingController::class, 'create'])->name('food.create');
    Route::post('/settings/food/store', [SettingController::class, 'store'])->name('food.store');
    Route::get('/settings/food/show', [SettingController::class, 'show'])->name('food.show');
    Route::put('/settings/food-update', [SettingController::class, 'food_update'])->name('food.update');
    Route::delete('/settings/food-delete', [SettingController::class, 'destroy'])->name('food.destroy');
    Route::get('/settings/user/show', [UserController::class, 'show'])->name('user.show');
    Route::put('/settings/user/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/settings/user/destroy', [UserController::class, 'destroy'])->name('user.destroy');
});
