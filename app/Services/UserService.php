<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserService {
    /**
     * ユーザーのバリデーション
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateUser(array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * ユーザーを作成する
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function createUser(array $data): User {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'name_kana' => $data['name_kana'],
                'username' => $data['username'],
                'email' => $data['email'],
                // Userモデルで自動ハッシュ化
                'password' => $data['password'], 
                'del_flg' => false,
            ]);

            return $user;
        });
    }
}