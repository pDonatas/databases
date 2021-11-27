<?php

use App\Http\Controllers\Car\CarController;
use App\Http\Controllers\User\UserController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['web', 'auth'])->group(function() {
    Route::impersonate();
    Route::resource('users', UserController::class);
    Route::resource('cars', CarController::class);
    Route::get('/cars/{car:id}/rent', [CarController::class, 'rent'])->name('cars.rent');
    Route::get('/cars/rent/stop', [CarController::class, 'stopRent'])->name('cars.rent.stop');
    Route::get('/cars/rent/stop/{id}', [CarController::class, 'stopRentForCar'])->name('cars.rent.stop.car');

    Route::get('/user/rents', [UserController::class, 'rents'])->name('user.rents');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
