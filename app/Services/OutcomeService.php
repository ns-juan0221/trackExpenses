<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\OutcomeGroup;
use App\Models\OutcomeItem;


class OutcomeService {
    /**
     * Outcomeデータのバリデーション
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateOutcome(array $data) {
        return Validator::make($data, [
            'date' => 'required|date',
            'shop' => 'required|string|max:255',
            'item' => 'required|array',
            'item.*' => 'required|string|max:255',
            'category' => 'required|array',
            'category.*' => [
                'required',
                'regex:/^outcome-main-\d+\|outcome-sub-\d+$/', // カテゴリの形式を検証
            ],
            'price' => 'required|array',
            'price.*' => 'required|numeric',
            'amount' => 'required|array',
            'amount.*' => 'required|numeric',
            'totalPrice' => 'required|numeric',
            'memo' => 'nullable|string|max:255',
        ]);
    }

    /**
     * OutcomeItemのデータを整える
     *
     * @param array $validatedData
     * @return array $itemsData
     */
    public function prepareItemsData(array $validatedData):array {
        $itemsData = [];

        foreach ($validatedData['item'] as $index => $itemName) {
            $categoryParts = explode('|', $validatedData['category'][$index]);
            $mainCategoryId = intval(str_replace('outcome-main-', '', $categoryParts[0]));
            $subCategoryId = intval(str_replace('outcome-sub-', '', $categoryParts[1]));

            $itemsData[] = [
                'date' => $validatedData['date'],
                'item' => $itemName,
                'm_category_id' => $mainCategoryId,
                's_category_id' => $subCategoryId,
                'price' => $validatedData['price'][$index],
                'amount' => $validatedData['amount'][$index],
            ];
        }
        return $itemsData;
    }   

    /**
     * OutcomeGroup と OutcomeItem のデータをまとめて作成する
     *
     * @param array $groupData
     * @param array $itemsData
     * @return \App\Models\OutcomeGroup
     */
    public function createOutcome(array $groupData, array $itemsData): OutcomeGroup {
        return DB::transaction(function () use ($groupData, $itemsData) {
            // OutcomeGroup を作成
            $outcomeGroup = OutcomeGroup::create([
                'user_id' => $groupData['user_id'],
                'date' => $groupData['date'],
                'shop' => $groupData['shop'],
                'totalPrice' => $groupData['totalPrice'],
                'memo' => $groupData['memo'] ?? '',
                'del_flg' => false,
            ]);

            $outcomeItems = [];
            // OutcomeGroup ID を利用して OutcomeItem を作成
            foreach ($itemsData as $itemData) {
                $outcomeItems[] = array_merge($itemData, [
                    'user_id' => session('user_id'),
                    'group_id' => $outcomeGroup->id,
                    'del_flg' => false,
                ]);
            }
            OutcomeItem::insert($outcomeItems);

            return $outcomeGroup;
        });
    }
}