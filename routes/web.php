<?php

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

// Route::get('/', function () {
//     return redirect()->route('main');
// });

Route::get('/login', function () {
    return view('login');
})->name('login.guest');

Route::get('/main', function () {
    return view('main');
})->name('main');

Route::get('/new', function () {
    return view('create');
})->name('new-income');

Route::get('/new', function () {
    $toggle = request('toggle');
    return view('create', ['toggle' => $toggle]);
})->name('new');

Route::get('/regist', function () {
    return view('regist');
})->name('regist');

Route::get('/setting', function() {
    return view('setting');
})->name('setting');

Route::get('/reset-password', function() {
    return view('reset-password');
})->name('reset-password');

Route::get('/log', function () {
    $type = request('type');
    return view('log', ['type' => $type]);
})->name('log');

Route::get('/guest', function () {
    return view('guest');
})->name('guest');
