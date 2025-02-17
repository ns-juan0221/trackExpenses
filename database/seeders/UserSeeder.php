<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder {
    public function run() {
        User::create([
            'name' => 'test',
            'name_kana' => 'test',
            'username' => 'test',
            'email' => 'test@test.test',
            'password' => 'testest',
            'del_flg' => 0,
        ]);
    }
}
