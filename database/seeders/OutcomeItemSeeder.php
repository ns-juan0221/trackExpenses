<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OutcomeItem;
use Carbon\Carbon;

class OutcomeItemSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) { 
            $num = rand(1, 10);

            $item_num = rand(1, 10);
            $item = "";
            $m_category_id = "";
            $s_category_id = "";

            switch ($item_num) {
                case 1:
                    $item = "サプリメント";
                    $m_category_id = 1;
                    $s_category_id = 6;

                    break;
                case 2:
                    $item = "タクシー代";
                    $m_category_id = 3;
                    $s_category_id = 20;

                    break;
                case 3:
                    $item = "シャーペン";
                    $m_category_id = 6;
                    $s_category_id = 42;

                    break;
                case 4:
                    $item = "ユーキャン";
                    $m_category_id = 8;
                    $s_category_id = 59;

                    break;
                case 5:
                    $item = "飲み会費";
                    $m_category_id = 6;
                    $s_category_id = 45;

                    break;
                case 6:
                    $item = "ニキビクリーム";
                    $m_category_id = 9;
                    $s_category_id = 65;

                    break;
                case 7:
                    $item = "ドリームキャッチャー";
                    $m_category_id = 11;
                    $s_category_id = 80;

                    break;
                case 8:
                    $item = "カルピス";
                    $m_category_id = 1;
                    $s_category_id = 2;

                    break;
                case 9:
                    $item = "ティッシュ";
                    $m_category_id = 2;
                    $s_category_id = 13;

                    break;
                case 10:
                    $item = "切手";
                    $m_category_id = 4;
                    $s_category_id = 31;

                    break;
                default:
                    # code...
                    break;
            }

            OutcomeItem::create([
                'user_id' => 1,
                'group_id' => $num,
                'date' => Carbon::parse('2024-12-01')->addDays($num -1)->format('Y-m-d'),
                'item' => $item,
                'm_category_id' => $m_category_id,
                's_category_id' => $s_category_id,
                'price' => rand(100, 500),  
                'amount' => rand(1,3),
                'del_flg' => 0,
            ]);
        }
    }
}
