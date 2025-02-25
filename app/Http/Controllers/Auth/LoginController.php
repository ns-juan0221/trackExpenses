<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Validation\ValidationException;

class LoginController extends Controller {
    /**
     * ログインページを表示する
     * 
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('login');
    }

    /**
     * ユーザ登録画面を表示する
     * 
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('newUser');
    }

    /**
     * ゲストユーザーのログイン処理をする
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guestLogin() {
        try{
            // ID=1のユーザーでログイン
            $user = User::find(1);

            if ($user) {
                Auth::login($user);
                session()->regenerate();
        
                session(['user_id' => Auth::id()]);
        
                return redirect()->route('main');
            } else {
                return back()->withErrors(['login_error' => 'ゲストユーザにログインできませんでした']) ;
            }
        }catch (\Exception $e) {
            return back()->withErrors(['login_error' => '予期しないエラーが発生しました'])->withInput();
        }
    }

    /**
     * ユーザーのログイン処理をする
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request) {
        try{
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
            $validator->validate();

            if (Auth::attempt($request->only('email', 'password'))) {
                $request->session()->regenerate();

                session(['user_id' => Auth::id()]);

                return redirect()->route('main');
            } else {
                return back()->withErrors(['login_error' => 'メールアドレスまたはパスワードが間違っています']) ;
            }

        }catch(ValidationException $e) {
            return back()->withErrors(['login_error' => '入力内容にエラーがあります'])->withInput();
        }catch (\Exception $e) {
            return back()->withErrors(['login_error' => '予期しないエラーが発生しました'])->withInput();
        }
    }

    /**
     * ユーザーのログアウト処理をする
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) {
        Auth::logout();

        session()->forget('user_id');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
