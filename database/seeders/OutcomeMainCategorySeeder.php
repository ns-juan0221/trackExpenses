<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OutcomeMainCategory;

class OutcomeMainCategorySeeder extends Seeder
{
    public function run()
    {
        OutcomeMainCategory::create(['name' => '食費', 'del_flg' => 0]); //1
        OutcomeMainCategory::create(['name' => '日用品', 'del_flg' => 0]); //2
        OutcomeMainCategory::create(['name' => '交通費', 'del_flg' => 0]); //3
        OutcomeMainCategory::create(['name' => '通信費', 'del_flg' => 0]); //4
        OutcomeMainCategory::create(['name' => '住まい', 'del_flg' => 0]); //5
        OutcomeMainCategory::create(['name' => '交際費', 'del_flg' => 0]); //6
        OutcomeMainCategory::create(['name' => '娯楽・趣味', 'del_flg' => 0]); //7
        OutcomeMainCategory::create(['name' => '教育・教養費', 'del_flg' => 0]); //8
        OutcomeMainCategory::create(['name' => '医療・保険', 'del_flg' => 0]); //9
        OutcomeMainCategory::create(['name' => '美容・衣服', 'del_flg' => 0]); //10
        OutcomeMainCategory::create(['name' => 'クルマ', 'del_flg' => 0]); //11
        OutcomeMainCategory::create(['name' => '税金', 'del_flg' => 0]); //12
        OutcomeMainCategory::create(['name' => '大型出費', 'del_flg' => 0]); //13
        OutcomeMainCategory::create(['name' => 'その他', 'del_flg' => 0]); //14
    }
}
