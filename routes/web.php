<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OutcomeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\SearchController;
use App\Repositories\CategoryRepository;
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

//ゲストページ
Route::get('guest', [ViewController::class, 'getSampleHalfYearGroupsAndLeastItems'])
    ->name('guest');

// ユーザー登録関連
Route::get('register', [UserController::class, 'create'])
    ->name('register');
Route::post('register', [UserController::class, 'store']);

// ログイン関連
Route::get('login', [LoginController::class, 'index'])
    ->name('login'); 
Route::post('login', [LoginController::class, 'login']); 
Route::get('logout', [LoginController::class, 'logout'])
    ->name('logout');

//メイン画面
Route::get('main', [ViewController::class, 'getHalfYearGroupsAndLeastItemsToRedirectMain'])
    ->name('main')
    ->middleware('auth');

//追加画面
Route::get('new', [CategoryController::class, 'getCategoriesToInsert'])
    ->name('new')
    ->middleware('auth');

Route::post('store', [MainController::class, 'store'])
    ->name('store');

//検索画面
Route::get('histories', [CategoryController::class, 'getCategoriesToSeeHistories'])
    ->name('histories')
    ->middleware('auth');

// パスワードリセット関連
// Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
// ->name('password.request');
// Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
// ->name('password.email');
// Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
// ->name('password.reset');
// Route::post('/password/reset', [ResetPasswordController::class, 'reset'])
// ->name('password.update');

// Route::get('setting', function() {
//     return view('setting');
// })->name('setting');

// Route::get('reset-password', function() {
//     return view('reset-password');
// })->name('reset-password');
