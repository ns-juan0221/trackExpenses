<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
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

//ゲストログイン
Route::get('guestLogin', [LoginController::class, 'guestLogin'])
    ->name('guestLogin');

// ユーザー登録関連
Route::get('createUser', [UserController::class, 'create'])
    ->name('createUser');
Route::post('createUser', [UserController::class, 'store']);

// ログイン関連
Route::get('/', [LoginController::class, 'index'])
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