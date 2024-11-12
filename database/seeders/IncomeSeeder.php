<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Income;

class IncomeSeeder extends Seeder
{
    public function run()
    {
        Income::create([
            'date' => '2024-01-01',
            'amount' => 50000.00,
            'category_id' => 1,
            'memo' => '月給',
            'user_id' => 1,
            'del_flg' => 0,
        ]);

        Income::create([
            'date' => '2024-01-15',
            'amount' => 10000.00,
            'category_id' => 2,
            'memo' => '臨時収入',
            'user_id' => 1,
            'del_flg' => 0,
        ]);
    }
}
