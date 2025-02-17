<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IncomeCategory;

class IncomeCategorySeeder extends Seeder {
    public function run() {
        IncomeCategory::create(['name' => '給与所得', 'del_flg' => 0]);
        IncomeCategory::create(['name' => '賞与', 'del_flg' => 0]);
        IncomeCategory::create(['name' => '立替金返済', 'del_flg' => 0]);
        IncomeCategory::create(['name' => '臨時収入', 'del_flg' => 0]);
        IncomeCategory::create(['name' => '投資収入', 'del_flg' => 0]);
        IncomeCategory::create(['name' => '事業所得', 'del_flg' => 0]);
        IncomeCategory::create(['name' => 'その他', 'del_flg' => 0]);
    }
}
