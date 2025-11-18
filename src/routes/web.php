<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


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

// 会員登録
Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// メール認証
Route::get('/email/verify', function () {
    return view('auth.verify-email'); // メール認証画面を表示
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); 
    return redirect('/attendance'); // メール認証成功時にリダイレクト
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/attendance'); // 既に認証済みの場合はリダイレクト
    }

    $request->user()->sendEmailVerificationNotification(); // 認証メールを送信

    return back()->with('status', 'verification-link-sent'); // 認証メール送信後のリダイレクト
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ログイン画面
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// 勤怠登録画面
Route::get('attendance', [AttendanceController::class, 'create'])->middleware(['auth', 'verified'])->name('attendance.create');
Route::post('attendance', [AttendanceController::class, 'store'])->middleware(['auth', 'verified'])->name('attendance.store');