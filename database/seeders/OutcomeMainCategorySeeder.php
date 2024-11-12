<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OutcomeMainCategory;

class OutcomeMainCategorySeeder extends Seeder
{
    public function run()
    {
        OutcomeMainCategory::create(['name' => '食費', 'del_flg' => 0]);
        OutcomeMainCategory::create(['name' => '日用品', 'del_flg' => 0]);
        OutcomeMainCategory::create(['name' => '交通', 'del_flg' => 0]);
    }
}
