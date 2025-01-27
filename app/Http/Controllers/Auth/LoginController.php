<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Validation\ValidationException;

class LoginController extends Controller {
    public function index() {
        return view('login'); // ログイン画面のビューを返す
    }

    // 認証処理
    public function login(Request $request) {
        try{
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
            $validator->validate();

            // 認証処理
            if (Auth::attempt($request->only('email', 'password'))) {
                // Laravelセッションの再生成
                $request->session()->regenerate();

                // 認証成功後、user_idをセッションに保存
                session(['user_id' => Auth::id()]);

                // メイン画面へリダイレクト
                return redirect()->route('getHalfYearGroupsAndLeastItemsToRedirectMain');
            } else {
                // 認証失敗の場合はエラーメッセージを返す
                return back()->withErrors(['login_error' => 'メールアドレスまたはパスワードが間違っています']) ;
            }

        }catch(ValidationException $e) {
            return back()->withErrors(['login_error' => '入力内容にエラーがあります'])->withInput();

        }catch (\Exception $e) {
            // その他の例外をキャッチしてエラーメッセージを表示
            return back()->withErrors(['login_error' => '予期しないエラーが発生しました'])->withInput();

        }
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
