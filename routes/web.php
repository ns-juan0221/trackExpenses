<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OutcomeController;
use App\Http\Controllers\SearchController;
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
Route::get('guest', [MainController::class, 'guestIndex'])
    ->name('guest');

// ユーザー登録関連
Route::get('new', [UserController::class, 'create'])
    ->name('new');
Route::post('new', [UserController::class, 'store']);

// ログイン関連
Route::get('login', [LoginController::class, 'index'])
    ->name('login'); 
Route::post('login', [LoginController::class, 'login']); 
Route::get('logout', [LoginController::class, 'logout'])
    ->name('logout');

//メイン画面
Route::get('main', [MainController::class, 'index'])
    ->name('main')
    ->middleware('auth');

//追加画面
Route::get('register', [MainController::class, 'create'])
    ->name('register')
    ->middleware('auth');

Route::post('store', [MainController::class, 'store'])
    ->name('store');

//履歴画面
Route::get('histories', [MainController::class, 'show'])
    ->name('histories')
    ->middleware('auth');

Route::post('histories', [MainController::class, 'search'])
    ->name('histories.post')
    ->middleware('auth');

//詳細画面
Route::post('detail', [MainController::class, 'showDetail'])
    ->name('detail')
    ->middleware('auth');

//編集画面
Route::get('edit/{id}/{type}', [MainController::class, 'edit'])
    ->name('edit')
    ->middleware('auth');

Route::post('update', [MainController::class, 'update'])
    ->name('update')
    ->middleware('auth');

//アイテム削除
Route::delete('delete', [MainController::class, 'destroy'])
    ->name('delete')
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
