<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Income;

class IncomeSeeder extends Seeder {
    public function run() {
        Income::create([
            'date' => '2025-01-24',
            'amount' => 300000.00,
            'category_id' => 1,
            'memo' => '今月から昇給',
            'user_id' => 1,
            'del_flg' => 0,
        ]);

        Income::create([
            'date' => '2024-12-15',
            'amount' => 300000.00,
            'category_id' => 2,
            'memo' => 'ボーナス',
            'user_id' => 1,
            'del_flg' => 0,
        ]);

        Income::create([
            'date' => '2025-02-15',
            'amount' => 100000.00,
            'category_id' => 3,
            'memo' => '友人に貸してたお金',
            'user_id' => 1,
            'del_flg' => 0,
        ]);

        Income::create([
            'date' => '2024-12-20',
            'amount' => 100000.00,
            'category_id' => 4,
            'memo' => '叔父から',
            'user_id' => 1,
            'del_flg' => 0,
        ]);

        Income::create([
            'date' => '2025-01-10',
            'amount' => 100000.00,
            'category_id' => 5,
            'memo' => '5%利確したから',
            'user_id' => 1,
            'del_flg' => 0,
        ]);

        Income::create([
            'date' => '2024-11-10',
            'amount' => 1000000.00,
            'category_id' => 6,
            'memo' => '',
            'user_id' => 1,
            'del_flg' => 0,
        ]);

        Income::create([
            'date' => '2024-11-10',
            'amount' => 100000.00,
            'category_id' => 7,
            'memo' => '',
            'user_id' => 1,
            'del_flg' => 0,
        ]);
    }
}
