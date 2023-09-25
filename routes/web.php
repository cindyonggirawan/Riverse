<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityStatusController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\ExperiencePointStatusController;
use App\Http\Controllers\FasilitatorController;
use App\Http\Controllers\FasilitatorTypeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SukarelawanController;
use App\Http\Controllers\SukarelawanStatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationStatusController;
use App\Http\Controllers\VerifyFasilitatorController;
use App\Http\Controllers\VerifySukarelawanController;
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

// Route::get('/', function () {
//     return view('home');
// });

// Route::get('/component', function () {
//     return view('testingComponent');
// });

// Route::get('/activities', [ActivityController::class, 'index']);

// Route::get('/activities/{slug}', [ActivityController::class, 'show']);

Route::get('/', function () {
    return view('admin.layouts.main', [
        'title' => 'Home'
    ]);
});

Route::get('/roles', [RoleController::class, 'index']);

Route::get('/roles/{role:slug}', [RoleController::class, 'show']);

Route::get('/fasilitator-types', [FasilitatorTypeController::class, 'index']);

Route::get('/fasilitator-types/{fasilitatorType:slug}', [FasilitatorTypeController::class, 'show']);

Route::get('/verification-statuses', [VerificationStatusController::class, 'index']);

Route::get('/verification-statuses/{verificationStatus:slug}', [VerificationStatusController::class, 'show']);

Route::get('/activity-statuses', [ActivityStatusController::class, 'index']);

Route::get('/activity-statuses/{activityStatus:slug}', [ActivityStatusController::class, 'show']);

Route::get('/sukarelawan-statuses', [SukarelawanStatusController::class, 'index']);

Route::get('/sukarelawan-statuses/{sukarelawanStatus:slug}', [SukarelawanStatusController::class, 'show']);

Route::get('/experience-point-statuses', [ExperiencePointStatusController::class, 'index']);

Route::get('/experience-point-statuses/{experiencePointStatus:slug}', [ExperiencePointStatusController::class, 'show']);

Route::get('/levels', [LevelController::class, 'index']);

Route::get('/levels/{level:slug}', [LevelController::class, 'show']);

Route::get('/benefits', [BenefitController::class, 'index']);

Route::get('/benefits/{benefit:slug}', [BenefitController::class, 'show']);





Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');

Route::get('/register/sukarelawan', [RegisterController::class, 'showSukarelawan']);

Route::post('/register/sukarelawan', [RegisterController::class, 'storeSukarelawan']);

Route::get('/register/fasilitator', [RegisterController::class, 'showFasilitator']);

Route::post('/register/fasilitator', [RegisterController::class, 'storeFasilitator']);

Route::get('/users', [UserController::class, 'index']);

Route::get('/users/{user:slug}', [UserController::class, 'show']);

Route::get('/sukarelawans', [SukarelawanController::class, 'index']);

Route::get('/sukarelawans/{sukarelawan:slug}', [SukarelawanController::class, 'show']);

Route::get('/fasilitators', [FasilitatorController::class, 'index']);

Route::get('/fasilitators/{fasilitator:slug}', [FasilitatorController::class, 'show']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');

Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/logout', [LoginController::class, 'logout']);





Route::get('/waiting-for-verification/sukarelawans', [VerifySukarelawanController::class, 'indexWaitingForVerificationSukarelawan']);

Route::patch('/verify/sukarelawans/{sukarelawan:slug}', [VerifySukarelawanController::class, 'updateVerifiedSukarelawan']);

Route::patch('/reject/sukarelawans/{sukarelawan:slug}', [VerifySukarelawanController::class, 'updateRejectedSukarelawan']);

Route::patch('/verify/all-sukarelawans', [VerifySukarelawanController::class, 'updateAllVerifiedSukarelawan']);

Route::patch('/reject/all-sukarelawans', [VerifySukarelawanController::class, 'updateAllRejectedSukarelawan']);

Route::get('/verified/sukarelawans', [VerifySukarelawanController::class, 'indexVerifiedSukarelawan']);

Route::patch('/unverify/sukarelawans/{sukarelawan:slug}', [VerifySukarelawanController::class, 'updateUnverifiedSukarelawan']);

Route::patch('/unverify/all-sukarelawans', [VerifySukarelawanController::class, 'updateAllUnverifiedSukarelawan']);

Route::get('/rejected/sukarelawans', [VerifySukarelawanController::class, 'indexRejectedSukarelawan']);

Route::patch('/unreject/sukarelawans/{sukarelawan:slug}', [VerifySukarelawanController::class, 'updateUnrejectedSukarelawan']);

Route::patch('/unreject/all-sukarelawans', [VerifySukarelawanController::class, 'updateAllUnrejectedSukarelawan']);

Route::get('/all/sukarelawans', [VerifySukarelawanController::class, 'indexAllSukarelawan']);





Route::get('/waiting-for-verification/fasilitators', [VerifyFasilitatorController::class, 'indexWaitingForVerificationFasilitator']);

Route::patch('/verify/fasilitators/{fasilitator:slug}', [VerifyFasilitatorController::class, 'updateVerifiedFasilitator']);

Route::patch('/reject/fasilitators/{fasilitator:slug}', [VerifyFasilitatorController::class, 'updateRejectedFasilitator']);

Route::patch('/verify/all-fasilitators', [VerifyFasilitatorController::class, 'updateAllVerifiedFasilitator']);

Route::patch('/reject/all-fasilitators', [VerifyFasilitatorController::class, 'updateAllRejectedFasilitator']);

Route::get('/verified/fasilitators', [VerifyFasilitatorController::class, 'indexVerifiedFasilitator']);

Route::patch('/unverify/fasilitators/{fasilitator:slug}', [VerifyFasilitatorController::class, 'updateUnverifiedFasilitator']);

Route::patch('/unverify/all-fasilitators', [VerifyFasilitatorController::class, 'updateAllUnverifiedFasilitator']);

Route::get('/rejected/fasilitators', [VerifyFasilitatorController::class, 'indexRejectedFasilitator']);

Route::patch('/unreject/fasilitators/{fasilitator:slug}', [VerifyFasilitatorController::class, 'updateUnrejectedFasilitator']);

Route::patch('/unreject/all-fasilitators', [VerifyFasilitatorController::class, 'updateAllUnrejectedFasilitator']);

Route::get('/all/fasilitators', [VerifyFasilitatorController::class, 'indexAllFasilitator']);
