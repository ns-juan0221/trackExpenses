<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutcomeSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2025-02-17');
        $totalItems = 1000;
        
        $subCategories = DB::table('outcome_sub_categories')->pluck('id')->toArray();
        $mainCategoryMap = DB::table('outcome_sub_categories')->pluck('main_category_id', 'id');
        
        $groupCount = ceil($totalItems / 5);
        
        $groupIds = [];
        for ($i = 1; $i <= $groupCount; $i++) {
            $date = $startDate->copy()->addDays(rand(0, $endDate->diffInDays($startDate)))->format('Y-m-d');
            $groupId = DB::table('outcome_groups')->insertGetId([
                'user_id' => 1,
                'date' => $date,
                'shop' => 'ショップ' . $i,
                'totalPrice' => 0,
                'del_flg' => 0,
            ]);
            $groupIds[] = $groupId;
        }
        
        $items = [];
        foreach (range(1, $totalItems) as $num) {
            $s_category_id = $subCategories[array_rand($subCategories)];
            $m_category_id = $mainCategoryMap[$s_category_id];
            $price = rand(100, 500);
            $amount = rand(1, 3);
            $group_id = $groupIds[array_rand($groupIds)];
            $date = DB::table('outcome_groups')->where('id', $group_id)->value('date');
            
            $items[] = [
                'user_id' => 1,
                'group_id' => $group_id,
                'date' => $date,
                'item' => 'アイテム' . $num,
                'm_category_id' => $m_category_id,
                's_category_id' => $s_category_id,
                'price' => $price,
                'amount' => $amount,
                'del_flg' => 0,
            ];
        }
        
        DB::table('outcome_items')->insert($items);
        
        // OutcomeGroup の totalPrice を更新
        foreach ($groupIds as $groupId) {
            $totalPrice = DB::table('outcome_items')->where('group_id', $groupId)->sum(DB::raw('price * amount'));
            DB::table('outcome_groups')->where('id', $groupId)->update(['totalPrice' => $totalPrice]);
        }
    }
}
