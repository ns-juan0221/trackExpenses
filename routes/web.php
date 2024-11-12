<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\MainController;
use App\Http\Controllers\OutcomeController;
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

Route::get('guest', [OutcomeController::class, 'sampleShowMonthlyHalfYear'])->name('guest');

// ログイン関連
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login'); // ログイン画面
Route::post('login', [LoginController::class, 'login']); // 認証処理
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('showMonthlyHalfYear/{userId}', [OutcomeController::class, 'showMonthlyHalfYear'])->name('showMonthlyHalfYear');
Route::get('main', [MainController::class, 'index'])->name('main')->middleware('auth'); // メイン画面


// パスワードリセット関連
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/assword/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// ユーザー登録関連
Route::get('regist', [RegisterController::class, 'showRegistrationForm'])->name('regist');
Route::post('regist', [RegisterController::class, 'register']);


Route::get('new', function () {
    return view('create');
})->name('new-income');

Route::get('new', function () {
    $toggle = request('toggle');
    return view('create', ['toggle' => $toggle]);
})->name('new');

Route::get('setting', function() {
    return view('setting');
})->name('setting');

Route::get('reset-password', function() {
    return view('reset-password');
})->name('reset-password');

Route::get('log', function () {
    $type = request('type');
    return view('log', ['type' => $type]);
})->name('log');



