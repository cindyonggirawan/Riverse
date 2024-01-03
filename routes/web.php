<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\FasilitatorController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SukarelawanController;
use App\Http\Controllers\VerifyActivityController;
use App\Http\Controllers\VerifyFasilitatorController;
use App\Http\Controllers\VerifySukarelawanController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\VerifySukarelawanAttendanceController;
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

/* ADMIN SECTION */

Route::middleware(['web', 'admin'])->group(function () {

    // ADMIN HOME
    Route::get('/admin', function () {
        return view('admin.layouts.main', [
            'title' => 'Admin Home'
        ]);
    });

    // VERIFY SUKARELAWAN STATUS
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

    // VERIFY FASILITATOR STATUS
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

    // VERIFY ACTIVITY STATUS
    Route::get('/waiting-for-verification/activities', [VerifyActivityController::class, 'indexWaitingForVerificationActivity']);
    Route::patch('/verify/activities/{activity:slug}', [VerifyActivityController::class, 'updateVerifiedActivity']);
    Route::patch('/reject/activities/{activity:slug}', [VerifyActivityController::class, 'updateRejectedActivity']);
    Route::patch('/verify/all-activities', [VerifyActivityController::class, 'updateAllVerifiedActivity']);
    Route::patch('/reject/all-activities', [VerifyActivityController::class, 'updateAllRejectedActivity']);
    Route::get('/verified/activities', [VerifyActivityController::class, 'indexVerifiedActivity']);
    Route::patch('/unverify/activities/{activity:slug}', [VerifyActivityController::class, 'updateUnverifiedActivity']);
    Route::patch('/unverify/all-activities', [VerifyActivityController::class, 'updateAllUnverifiedActivity']);
    Route::get('/rejected/activities', [VerifyActivityController::class, 'indexRejectedActivity']);
    Route::patch('/unreject/activities/{activity:slug}', [VerifyActivityController::class, 'updateUnrejectedActivity']);
    Route::patch('/unreject/all-activities', [VerifyActivityController::class, 'updateAllUnrejectedActivity']);
    Route::get('/all/activities', [VerifyActivityController::class, 'indexAllActivity']);

    // BENEFIT SECTION
    Route::get('/admin/benefits', [BenefitController::class, 'index']);
    Route::delete('/admin/benefits/{benefit:slug}', [BenefitController::class, 'destroy']);
    Route::delete('/admin/benefits', [BenefitController::class, 'destroyAll']);
    Route::get('/admin/benefits/create', [BenefitController::class, 'create']);
    Route::post('/admin/benefits/create', [BenefitController::class, 'store']);
});
/* == END OF ADMIN SECTION == */



/* FASILITATOR SECTION */
Route::middleware(['web', 'fasilitator'])->group(function () {

    // FASILITATOR CREATE ACTIVITY
    Route::get('/activities/create/{step?}', [ActivityController::class, 'publicCreate'])->name('activity.publicCreate');
    Route::post('/activities/create/{step}', [ActivityController::class, 'publicStore'])->name('activity.publicStore');

    // FASILITATOR UPDATE THEIR ACTIVITY
    Route::get('/activities/{activity:slug}/edit/{step?}', [ActivityController::class, 'publicEdit'])->name('activity.publicEdit')->middleware("fasilitator");
    Route::patch('/activities/{activity:slug}/{step}', [ActivityController::class, 'publicUpdate'])->name('activity.publicUpdate')->middleware("fasilitator");

    // FASILITATOR DELETE THEIR ACTIVITY
    Route::delete('/activities/{activity:slug}/delete', [ActivityController::class, 'publicDestroy'])->name('activity.publicDestroy')->middleware('fasilitator');

    // FASILITATOR UPDATE PROFILE
    Route::get('/fasilitators/{fasilitator:slug}', [FasilitatorController::class, 'publicShow']);
    Route::get('/fasilitators/{fasilitator:slug}/edit', [FasilitatorController::class, 'publicEdit'])->name('fasilitator.edit');
    Route::patch('/fasilitators/{fasilitator:slug}/edit', [FasilitatorController::class, 'publicUpdate'])->name('fasilitator.update');

    // FASILITATOR MANAGE THEIR ACTIVITY
    Route::get('/fasilitators/{fasilitator:slug}/manage', [FasilitatorController::class, 'manage']);

    // FASILITATOR FINALIZE ATTENDANCE
    Route::get('/{activity:slug}/waiting-for-verification/joinedSukarelawanAttendance', [VerifySukarelawanAttendanceController::class, 'indexJoinedSukarelawan']);
    Route::get('/{activity:slug}/waiting-for-verification/clockedInSukarelawanAttendance', [VerifySukarelawanAttendanceController::class, 'indexClockedInSukarelawan']);
    Route::get('/{activity:slug}/verified/claimedSukarelawanAttendance', [VerifySukarelawanAttendanceController::class, 'indexClaimedSukarelawan']);
    Route::patch('/verify/joinedSukarelawanAttendance/{sukarelawanActivityDetail:id}', [VerifySukarelawanAttendanceController::class, 'updateJoinedSukarelawan']);
    Route::patch('/verify/clockedInSukarelawanAttendance/{sukarelawanActivityDetail:id}', [VerifySukarelawanAttendanceController::class, 'updateClockedInSukarelawan']);
    Route::patch('/reject/claimedSukarelawanAttendance/{sukarelawanActivityDetail:id}', [VerifySukarelawanAttendanceController::class, 'updateClaimedSukarelawan']);
});
/* == END OF FASILITATOR SECTION == */



/* SUKARELAWAN SECTION */
Route::middleware(['web', 'sukarelawan'])->group(function () {

    // SUKARELAWAN UPDATE PROFILE
    Route::get('/sukarelawans/{sukarelawan:slug}', [SukarelawanController::class, 'publicShow']);
    Route::get('/sukarelawans/{sukarelawan:slug}/edit', [SukarelawanController::class, 'publicEdit']);
    Route::patch('/sukarelawans/{sukarelawan:slug}', [SukarelawanController::class, 'publicUpdate'])->name("sukarelawan.update");

    // SUKARELAWAN LIKE UNLIKE ACTIVITY
    Route::post('/activities/{activity:slug}/like', [ActivityController::class, 'like'])->name('activities.like');
    Route::post('/activities/{activity:slug}/join', [ActivityController::class, 'joinActivity'])->name('activities.join');
    Route::post('/activities/{activity:slug}/unjoin', [ActivityController::class, 'unjoinActivity'])->name('activities.unjoin');

    // SUKARELAWAN MANAGE THEIR ACTIVITY
    Route::get('/sukarelawans/{sukarelawan:slug}/manage', [SukarelawanController::class, 'manage']);

    // SUKARELAWAN TAKE ATTENDANCE
    Route::post('/activities/{activity:slug}/attend', [ActivityController::class, 'takeAttendance'])->name('activities.attend');
});
/* == END OF SUKARELAWAN SECTION == */



/* GUEST SECTION */
Route::get('/', [ActivityController::class, 'fetchHomePageActivities']);

// REGISTER SECTION
Route::get('/register/fasilitator/{step?}', [RegisterController::class, 'showFasilitator'])->name('fasilitator.show')->middleware('guest');
Route::post('/register/fasilitator/{step}', [RegisterController::class, 'storeFasilitator'])->name('fasilitator.store')->middleware('guest');

Route::get('/register/sukarelawan/{step?}', [RegisterController::class, 'showSukarelawan'])->name('sukarelawan.show')->middleware('guest');
Route::post('/register/sukarelawan/{step}', [RegisterController::class, 'storeSukarelawan'])->name('sukarelawan.store')->middleware('guest');

// LOGIN SECTION
Route::get('/login', [LoginController::class, 'publicIndex'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// FORGOT PASSWORD SECTION
Route::get('/forgot-password', [ForgotPasswordController::class, 'publicIndex'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetPasswordIndex'])->middleware('guest')->name('password.reset');
Route::get('/change-password/{user:slug}', [ForgotPasswordController::class, 'changePasswordIndex'])->name('password.change');
Route::patch('/change-password/{user:slug}', [ForgotPasswordController::class, 'changePassword'])->name('password.update.change');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->middleware('guest')->name('password.update');

// LEADERBOARD SECTION
Route::get('/leaderboard', [LeaderboardController::class, 'processAndShowLeaderboardData']);

//BENEFIT SECTION
Route::get('/benefits', [LevelController::class, 'publicIndex']);

// ACTIVITY SECTION
Route::get('/activities', [ActivityController::class, 'publicIndex'])->name('activities.index');
Route::get('/activities/{activity:slug}', [ActivityController::class, 'publicShow'])->name("activity.publicShow");

/* == END OF GUEST SECTION == */
