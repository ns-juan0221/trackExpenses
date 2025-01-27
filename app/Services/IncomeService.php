<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Income;

class IncomeService {
    /**
     * Incomeデータのバリデーション
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateIncome(array $data) {
        return Validator::make($data, [
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'category' => [
                'required',
                'regex:/^category-\d+$/', // カテゴリの形式を検証
            ],
            'memo' => 'nullable|string|max:255',
        ]);
    }

    /**
     * Income のデータを作成する
     *
     * @param array $incomeData
     * @return \App\Models\Income
     */
    public function createIncome(array $incomeData):Income {
        return DB::transaction(function () use ($incomeData) {
            $categoryId = intval(str_replace('category-', '', $incomeData['category']));

            $incomeData = Income::create([
                'user_id' => session('user_id'),
                'date' => $incomeData['date'],
                'amount' => $incomeData['amount'],
                'category_id' => $categoryId,
                'memo' => $incomeData['memo'] ?? '',
                'del_flg' => false,
            ]);

            return $incomeData;
        });
    }

}