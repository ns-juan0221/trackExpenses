<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\OutcomeGroup;
use App\Models\OutcomeItem;
use Illuminate\Support\Facades\Log;

class OutcomeService {
    /**
     * 支出データのバリデーションを行う
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
     * 支出データのバリデーションを行う
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateUpdatedOutcome(array $data) {
        // delFlgが0のインデックスだけ抽出
        $validIndexes = collect($data['delFlg'] ?? [])
        ->filter(fn($flg) => $flg == 0)
        ->keys()
        ->all();

        $filteredData = [
            'date' => $data['date'] ?? null,
            'shop' => $data['shop'] ?? null,
            'totalPrice' => $data['totalPrice'] ?? null,
            'memo' => $data['memo'] ?? null,
            'item' => [],
            'category' => [],
            'price' => [],
            'amount' => [],
        ];

        foreach ($validIndexes as $i) {
            $filteredData['item'][$i] = $data['item'][$i] ?? null;
            $filteredData['category'][$i] = $data['category'][$i] ?? null;
            $filteredData['price'][$i] = $data['price'][$i] ?? null;
            $filteredData['amount'][$i] = $data['amount'][$i] ?? null;
        }

        return Validator::make($filteredData, [
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
     * バリデーション済みのデータから支出アイテムデータを準備する
     *
     * @param array $validatedData
     * @return array $itemsData
     */
    public function prepareItemsData(array $validatedData) {
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
     * OutcomeItemのデータを整える
     *
     * @param array $validatedData
     * @return array $itemsData
     */
    public function prepareUpdatedItemsData(array $validatedData) {
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
                'delFlg' => $validatedData['delFlg'][$index],
            ];
        }

        return $itemsData;
    }

    /**
     * 支出データを作成する
     *
     * @param array $outcomeGroupData
     * @param array $outcomeItemsData
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOutcome(array $outcomeGroupData, array $outcomeItemsData) {
        return DB::transaction(function () use ($outcomeGroupData, $outcomeItemsData) {
            $newOutcomeGroupData = OutcomeGroup::create([
                'user_id' => $outcomeGroupData['user_id'],
                'date' => $outcomeGroupData['date'],
                'shop' => $outcomeGroupData['shop'],
                'totalPrice' => $outcomeGroupData['totalPrice'],
                'memo' => $outcomeGroupData['memo'] ?? '',
                'del_flg' => false,
            ]);

            $newOutcomeItemsData = [];
            foreach ($outcomeItemsData as $outcomeItemData) {
                $newOutcomeItemsData[] = array_merge($outcomeItemData, [
                    'user_id' => session('user_id'),
                    'group_id' => $newOutcomeGroupData->id,
                    'del_flg' => false,
                ]);
            }

            OutcomeItem::insert($newOutcomeItemsData);

            return redirect()->route('register')->with('success', 'データを作成しました。');
        });
    }

    /**
     * 支出データを更新する
     *
     * @param array $updatedOutcomeGroupData
     * @param array $updatedOutcomeItemsData
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOutcome(array $updatedOutcomeGroupData, array $updatedOutcomeItemsData) {
        return DB::transaction(function () use ($updatedOutcomeGroupData, $updatedOutcomeItemsData) {
            $outcomeGroupData = OutcomeGroup::findOrFail($updatedOutcomeGroupData['id']);
            $outcomeGroupData->update([
                'date' => $updatedOutcomeGroupData['date'],
                'shop' => $updatedOutcomeGroupData['shop'],
                'totalPrice' => $updatedOutcomeGroupData['totalPrice'],
                'memo' => $updatedOutcomeGroupData['memo'] ?? '',
            ]);

            $existingItemIds = OutcomeItem::where('group_id', $updatedOutcomeGroupData['id'])
            ->pluck('id')
            ->toArray();
            $newItemIds = [];

            foreach ($updatedOutcomeItemsData as $itemData) {
                if (!empty($itemData['id'])) {
                    if (!empty($itemData['delFlg']) && $itemData['delFlg'] == 1) {
                        OutcomeItem::where('id', $itemData['id'])->update(['del_flg' => true]);
                    } else {
                        OutcomeItem::where('id', $itemData['id'])->update([
                            'date' => $itemData['date'],
                            'item' => $itemData['item'],
                            'm_category_id' => $itemData['m_category_id'],
                            's_category_id' => $itemData['s_category_id'],
                            'price' => $itemData['price'],
                            'amount' => $itemData['amount'],
                        ]);
                        $newItemIds[] = $itemData['id'];
                    }
                } else {
                    if (!empty($itemData['delFlg']) || $itemData['delFlg'] == 0) {
                        $newItem = OutcomeItem::create([
                            'user_id' => session('user_id'),
                            'group_id' => $updatedOutcomeGroupData['id'],
                            'date' => $itemData['date'],
                            'item' => $itemData['item'],
                            'm_category_id' => $itemData['m_category_id'],
                            's_category_id' => $itemData['s_category_id'],
                            'price' => $itemData['price'],
                            'amount' => $itemData['amount'],
                            'del_flg' => false,
                        ]);

                        $newItemIds[] = $newItem->id;
                    }
                }
            }

            $itemsToDelete = array_diff($existingItemIds, $newItemIds);

            if (!empty($itemsToDelete)) {
                OutcomeItem::whereIn('id', $itemsToDelete)->update(['del_flg' => true]);
            }

            return redirect()->route('histories')->with('success', 'データを更新しました。');
        });
    }

    /**
     * 指定したIDの支出データを削除する
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyOutcome(int $id) {
        $record = OutcomeGroup::findOrFail($id);
        $record->update(['del_flg' => 1]);

        OutcomeItem::where('group_id', $id)->update(['del_flg' => 1]);

        return redirect()->route('histories')->with('success', 'データを削除しました。');
    }
}