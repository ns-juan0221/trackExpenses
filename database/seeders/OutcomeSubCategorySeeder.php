<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OutcomeSubCategory;

class OutcomeSubCategorySeeder extends Seeder
{
    public function run()
    {
        OutcomeSubCategory::create(['main_category_id' => 1, 'name' => '食料品', 'del_flg' => 0]);
        OutcomeSubCategory::create(['main_category_id' => 1, 'name' => 'カフェ', 'del_flg' => 0]);
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => '消耗品', 'del_flg' => 0]);
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => '子ども関連', 'del_flg' => 0]);
        OutcomeSubCategory::create(['main_category_id' => 3, 'name' => '電車', 'del_flg' => 0]);
    }
}
