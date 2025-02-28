<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OutcomeGroup;
use Carbon\Carbon;

class OutcomeGroupSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) { 
            OutcomeGroup::create([
                'user_id' => 1,
                'date' => Carbon::parse('2024-12-01')->addDays($i -1)->format('Y-m-d'),
                // 'date' => Carbon::parse('2024-12-01')->addDays(rand(0, Carbon::parse('2024-12-10')->diffInDays(Carbon::parse('2024-01-01'))))->format('Y-m-d'),
                'shop' => 'ショップ' . $i,  // A〜Zのランダムなアルファベットと番号を組み合わせ
                'totalPrice' => rand(1000, 2000),  
                'del_flg' => 0,
            ]);
        }

        for ($i = 1; $i <= 1000; $i++) {
            OutcomeGroup::create([
                'user_id' => 1,
                'date' => Carbon::parse('2024-01-01')->addDays(rand(0, Carbon::parse('2025-01-01')->diffInDays(Carbon::parse('2024-01-01'))))->format('Y-m-d'),
                'shop' => 'ショップ' . chr(rand(65, 90)) . $i,  // A〜Zのランダムなアルファベットと番号を組み合わせ
                'totalPrice' => rand(1000, 10000),  
                'del_flg' => 0,
            ]);
        }

        for ($i = 1; $i <= 1000; $i++) {
            OutcomeGroup::create([
                'user_id' => 1,
                'date' => Carbon::parse('2023-01-01')->addDays(rand(0, Carbon::parse('2024-01-01')->diffInDays(Carbon::parse('2023-01-01'))))->format('Y-m-d'),
                'shop' => 'ショップ' . chr(rand(65, 90)) . $i,  // A〜Zのランダムなアルファベットと番号を組み合わせ
                'totalPrice' => rand(1000, 10000), 
                'del_flg' => 0,
            ]);
        }
    }
}
