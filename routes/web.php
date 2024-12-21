<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OutcomeController;
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

Route::get('guest', [OutcomeController::class, 'getSampleHalfYearGroups'])
->name('guest');

// ログイン関連
Route::get('login', [LoginController::class, 'index'])
->name('login'); // ログイン画面

Route::post('login', [LoginController::class, 'login']); // 認証処理

Route::get('logout', [LoginController::class, 'logout'])
->name('logout');

Route::get('getHalfYearGroupsAndLeastItems', [OutcomeController::class, 'getHalfYearGroupsAndLeastItems'])
->name('getHalfYearGroupsAndLeastItems')->middleware('auth');
Route::get('main', [MainController::class, 'index'])->middleware('auth');


// パスワードリセット関連
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// ユーザー登録関連
Route::get('register', [RegisterController::class, 'showRegistrationForm'])
->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('getCategoriesToSearch', [CategoryController::class, 'getCategoriesToSearch'])
->name('getCategoriesToSearch')->middleware('auth');
Route::get('search', [SearchController::class, 'index']);

Route::get('getCategoriesToInsert', [CategoryController::class, 'getCategoriesToInsert'])
->name('getCategoriesToInsert')->middleware('auth');
Route::get('new', [MainController::class, 'create'])
->name('new');

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


