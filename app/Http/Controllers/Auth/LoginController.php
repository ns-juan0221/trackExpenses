<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Validation\ValidationException;

class LoginController extends Controller {
    public function index() {
        return view('login'); // ログイン画面のビューを返す
    }

    // 認証処理
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            // Laravelセッションの再生成
            $request->session()->regenerate();

            // 認証成功後、user_idをセッションに保存
            session(['user_id' => Auth::id()]);

            return redirect()->route('getHalfYearGroupsAndLeastItems');
        }

        throw ValidationException::withMessages([
            'email' => __('ログイン情報が正しくありません。'),
        ]);
    }

    // ログアウト処理
    public function logout(Request $request) {
        Auth::logout();

    // user_idのセッションも削除
    session()->forget('user_id');

    // Laravelセッションを無効化
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');

    }
}
