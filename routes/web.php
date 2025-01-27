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
// ログイン画面
Route::get('login', [LoginController::class, 'index'])
->name('login'); 
// ログイン処理
Route::post('login', [LoginController::class, 'login']); 
//ログアウト処理
Route::get('logout', [LoginController::class, 'logout'])
->name('logout');

//メイン画面
Route::get('getHalfYearGroupsAndLeastItemsToRedirectMain', [ViewController::class, 'getHalfYearGroupsAndLeastItemsToRedirectMain'])
->name('getHalfYearGroupsAndLeastItemsToRedirectMain')->middleware('auth');
Route::get('main', [MainController::class, 'index'])->middleware('auth');

//追加画面
Route::get('getCategoriesToInsert', [CategoryController::class, 'getCategoriesToInsert'])
->name('getCategoriesToInsert')->middleware('auth');
Route::get('new', [MainController::class, 'create'])
->name('new');

Route::post('store', [MainController::class, 'store']) -> name('store');

//検索画面
Route::get('getCategoriesToSeeHistories', [CategoryController::class, 'getCategoriesToSeeHistories'])
->name('getCategoriesToSeeHistories')->middleware('auth');
Route::get('histories', [ViewController::class, 'index']);

// パスワードリセット関連
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

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


