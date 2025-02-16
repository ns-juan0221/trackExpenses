<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Income;

class IncomeService {
    /**
     * 収入データのバリデーションを行う
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateIncome(array $data) {
        if (isset($data['totalPrice'])) {
            $data['totalPrice'] = str_replace(',', '', $data['totalPrice']);
        }

        return Validator::make($data, [
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'category' => [
                'required',
                'regex:/^category-\d+$/',
            ],
            'memo' => 'nullable|string|max:255',
        ]);
    }

    /**
     * 収入データを作成する
     *
     * @param array $incomeData
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createIncome(array $incomeData) {
        return DB::transaction(function () use ($incomeData) {
            $categoryId = intval(str_replace('category-', '', $incomeData['category']));

            Income::create([
                'user_id' => session('user_id'),
                'date' => $incomeData['date'],
                'amount' => $incomeData['amount'],
                'category_id' => $categoryId,
                'memo' => $incomeData['memo'] ?? '',
                'del_flg' => false,
            ]);

            return redirect()->route('register')->with('success', 'データを作成しました。');
        });
    }

    /**
     * 収入データを更新する
     *
     * @param array $updatedIncomeData
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateIncome(array $updatedIncomeData) {
        return DB::transaction(function () use ($updatedIncomeData) {
            $categoryId = intval(str_replace('category-', '', $updatedIncomeData['category']));

            $incomeData = Income::findOrFail($updatedIncomeData['id']);
            $incomeData->update([
                'date' => $updatedIncomeData['date'],
                'amount' => $updatedIncomeData['amount'],
                'category_id' => $categoryId,
                'memo' => $updatedIncomeData['memo'] ?? '',
            ]);

            return redirect()->route('histories')->with('success', 'データを更新しました。');
        });
    }

    /**
     * 指定したIDの収入データを削除する
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyIncome(int $id) {
        $record = Income::findOrFail($id);
        $record->update(['del_flg' => 1]);

        return redirect()->route('histories')->with('success', 'データを削除しました。');
    }
}