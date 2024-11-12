<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IncomeCategory;

class IncomeCategorySeeder extends Seeder
{
    public function run()
    {
        IncomeCategory::create(['name' => '給与', 'del_flg' => 0]);
        IncomeCategory::create(['name' => '臨時収入', 'del_flg' => 0]);
        IncomeCategory::create(['name' => '投資収入', 'del_flg' => 0]);
    }
}
