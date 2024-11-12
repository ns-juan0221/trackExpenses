<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Validation\ValidationException;

class LoginController extends Controller {

    public function showLoginForm() {
        Log::info('loginページにアクセスします。');
        return view('login'); // ログイン画面のビューを返す
    }

    // 認証処理
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('mainへ飛びます');
            return redirect()->route('showMonthlyHalfYear', ['userId' => Auth::id()]);
        }

        throw ValidationException::withMessages([
            'email' => __('ログイン情報が正しくありません。'),
        ]);
    }

    // ログアウト処理
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
