<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    // 新規登録画面を表示
    public function showRegistrationForm() {
        Log::info('registページにアクセスします。');
        return view('regist');
    }

    // 新規ユーザー登録
    public function register(Request $request) {
        try {
            // バリデーションの実行
            $this->validator($request->all())->validate();
            Log::info('Validation passed'); // バリデーションが通ったことを記録

            // ユーザーの作成
            $user = $this->create($request->all());
            Log::info('User created: ' . $user->id);

            // ユーザー登録イベントの発火
            event(new Registered($user));

            // 登録後に自動ログイン
            auth()->login($user);

            // 登録後のリダイレクト
            return redirect()->route('main');
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        }
    }

    // バリデーション
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['nullable', 'string', 'max:255'], // name_kanaは任意入力
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // 新しいユーザーを作成
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'name_kana' => $data['name_kana'] ?? null, // name_kanaがnullでも保存
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'], // Userモデルのミューテタで自動ハッシュ化
            'del_flg' => false, // 新規ユーザーは削除フラグをfalseで設定
        ]);
    }
}
