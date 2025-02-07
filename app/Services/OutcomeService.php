<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\OutcomeGroup;
use App\Models\OutcomeItem;
use Illuminate\Support\Facades\Log;

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
                'regex:/^outcome-main-\d+\|outcome-sub-\d+$/',
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
        Log::info('itemsDataは以下のようになってます');
        Log::info($itemsData);
        return $itemsData;
    }   
    
    /**
     * OutcomeItemのデータを整える
     *
     * @param array $validatedData
     * @return array $itemsData
     */
    public function prepareUpdatedItemsData(array $validatedData):array {
        $itemsData = [];

        foreach ($validatedData['item'] as $index => $itemName) {
            $categoryParts = explode('|', $validatedData['category'][$index]);
            $mainCategoryId = intval(str_replace('outcome-main-', '', $categoryParts[0]));
            $subCategoryId = intval(str_replace('outcome-sub-', '', $categoryParts[1]));

            $itemsData[] = [
                'id' => $validatedData['id'][$index],
                'date' => $validatedData['date'],
                'item' => $itemName,
                'm_category_id' => $mainCategoryId,
                's_category_id' => $subCategoryId,
                'price' => $validatedData['price'][$index],
                'amount' => $validatedData['amount'][$index],
            ];
        }
        Log::info('itemsDataは以下のようになってます');
        Log::info($itemsData);
        return $itemsData;
    }   

    /**
     * OutcomeGroup と OutcomeItem のデータをまとめて作成する
     *
     * @param array $groupData
     * @param array $itemsData
     * @return \App\Models\OutcomeGroup
     */
    public function createOutcome(array $outcomeGroupData, array $outcomeItemsData): OutcomeGroup {
        return DB::transaction(function () use ($outcomeGroupData, $outcomeItemsData) {
            // OutcomeGroup を作成
            $newOutcomeGroupData = OutcomeGroup::create([
                'user_id' => $outcomeGroupData['user_id'],
                'date' => $outcomeGroupData['date'],
                'shop' => $outcomeGroupData['shop'],
                'totalPrice' => $outcomeGroupData['totalPrice'],
                'memo' => $outcomeGroupData['memo'] ?? '',
                'del_flg' => false,
            ]);

            $newOutcomeItemsData = [];
            // OutcomeGroup ID を利用して OutcomeItem を作成
            foreach ($outcomeItemsData as $outcomeItemData) {
                $newOutcomeItemsData[] = array_merge($outcomeItemData, [
                    'user_id' => session('user_id'),
                    'group_id' => $newOutcomeGroupData->id,
                    'del_flg' => false,
                ]);
            }
            OutcomeItem::insert($newOutcomeItemsData);

            return $newOutcomeGroupData;
        });
    }

    /**
     * OutcomeGroup と OutcomeItem のデータをまとめて更新する
     *
     * @param array $groupData
     * @param array $itemsData
     * @return \App\Models\OutcomeGroup
     */
    public function updateOutcome(array $updatedOutcomeGroupData, array $updatedOutcomeItemsData): OutcomeGroup {
        Log::info('updateOutcomeメソッドに入った');
        Log::info($updatedOutcomeItemsData);
        return DB::transaction(function () use ($updatedOutcomeGroupData, $updatedOutcomeItemsData) {
            // OutcomeGroup を作成
            $outcomeGroupData = OutcomeGroup::findOrFail($updatedOutcomeGroupData['id']);
            $outcomeGroupData->update([
                'date' => $updatedOutcomeGroupData['date'],
                'shop' => $updatedOutcomeGroupData['shop'],
                'totalPrice' => $updatedOutcomeGroupData['totalPrice'],
                'memo' => $updatedOutcomeGroupData['memo'] ?? '',
            ]);

            $existingItemIds = OutcomeItem::where('group_id', $updatedOutcomeGroupData['id'])->pluck('id')->toArray();
            $newItemIds = [];

            foreach ($updatedOutcomeItemsData as $updatedOutcomeItemData) {
                if (!empty($updatedOutcomeItemData['id'])) {
                    // 既存アイテムを更新
                    Log::info('IDは'.$updatedOutcomeItemData['id'].'です');
                    $item = OutcomeItem::findOrFail($updatedOutcomeItemData['id']);
                    $item->update([
                        'date' => $updatedOutcomeItemData['date'],
                        'item' => $updatedOutcomeItemData['item'],
                        'm_category_id' => $updatedOutcomeItemData['m_category_id'],
                        's_category_id' => $updatedOutcomeItemData['s_category_id'],
                        'price' => $updatedOutcomeItemData['price'],
                        'amount' => $updatedOutcomeItemData['amount'],
                    ]);
                    $newItemIds[] = $updatedOutcomeItemData['id'];
                } else {
                    Log::info($updatedOutcomeItemData);
                    // 新規アイテムを作成
                    $newItem = OutcomeItem::create([
                        'user_id' => session('user_id'),
                        'group_id' => $updatedOutcomeGroupData['id'],
                        'date' => $updatedOutcomeItemData['date'],
                        'item' => $updatedOutcomeItemData['item'],
                        'm_category_id' => $updatedOutcomeItemData['m_category_id'],
                        's_category_id' => $updatedOutcomeItemData['s_category_id'],
                        'price' => $updatedOutcomeItemData['price'],
                        'amount' => $updatedOutcomeItemData['amount'],
                        'del_flg' => false,
                    ]);
                    $newItemIds[] = $newItem->id;
                }
            }

            $itemsToDelete = array_diff($existingItemIds, $newItemIds);
            if (!empty($itemsToDelete)) {
                OutcomeItem::whereIn('id', $itemsToDelete)->update(['del_flg' => true]);
            }

            return $outcomeGroupData;
        });
    }

    public function destroyOutcome($id) {
        $record = OutcomeGroup::findOrFail($id);
        $record->update(['del_flg' => 1]);

        OutcomeItem::where('group_id', $id)->update(['del_flg' => 1]);

        return redirect()->route('histories')->with('success', 'データを削除しました。');
    }
}