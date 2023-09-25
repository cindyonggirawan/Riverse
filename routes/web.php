<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [Controller::class, 'index']);

Route::get('/component', function () {
    return view('testingComponent');
});

Route::get('/register/sukarelawan', [RegisterController::class, 'sukarelawanIndex'])->name('registerSukarelawan')->middleware('guest');
Route::get('/register/fasilitator', [RegisterController::class, 'fasilitatorIndex'])->name('registerFasilitator')->middleware('guest');

Route::post('/register/sukarelawan', [RegisterController::class, 'storeSukarelawan'])->middleware('guest');
Route::post('/register/fasilitator', [RegisterController::class, 'storeFasilitator'])->middleware('guest');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/logout', [LoginController::class, 'logout']);
