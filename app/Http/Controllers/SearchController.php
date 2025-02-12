<?php

namespace App\Http\Controllers;


use App\Models\Income;
use App\Models\OutcomeItem;
use App\Models\OutcomeGroup;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request) {
        Log::info($request);

        // クエリビルダーの初期化
        $outcomeQuery = null;
        $incomeQuery = null;
        $shouldSearchOutcome = false;
        $shouldSearchIncome = false;

        // メモ検索 (OutcomeGroup & Income)
        if ($request->filled('memo-keyword')) {
            $memoKeyword = $request->input('memo-keyword');
            if (!$outcomeQuery) {
                $outcomeQuery = OutcomeGroup::query();
            }
            $outcomeQuery->where('memo', 'like', "%{$memoKeyword}%");
            $shouldSearchOutcome = true;

            if($incomeQuery) {
                if (!$incomeQuery) {
                    $incomeQuery = Income::query();
                }
            $incomeQuery->where('memo', 'like', "%{$memoKeyword}%");
            $shouldSearchIncome = true;
            }
        }

        // 金額検索 (OutcomeGroup & Income)
        if ($request->filled('min_price') || $request->filled('max_price')) {
            if (!$outcomeQuery) {
                $outcomeQuery = OutcomeGroup::query();
            }
            if (!$incomeQuery) {
                $incomeQuery = Income::query();
            }

            if ($request->filled('min_price')) {
                $minPrice = $request->input('min_price');
                $outcomeQuery->where('totalPrice', '>=', $minPrice);
                $incomeQuery->where('amount', '>=', $minPrice);
            }

            if ($request->filled('max_price')) {
                $maxPrice = $request->input('max_price');
                $outcomeQuery->where('totalPrice', '<=', $maxPrice);
                $incomeQuery->where('amount', '<=', $maxPrice);
            }

            $shouldSearchOutcome = true;
            $shouldSearchIncome = true;
        }

        // 日付検索 (OutcomeGroup & Income)
        if ($request->filled('min_date') || $request->filled('max_date')) {
            if (!$outcomeQuery) {
                $outcomeQuery = OutcomeGroup::query();
            }

            if (!$incomeQuery) {
                $incomeQuery = Income::query();
            }

            if ($request->filled('min_date')) {
                $minDate = $request->input('min_date');
                $outcomeQuery->where('date', '>=', $minDate);
                $incomeQuery->where('date', '>=', $minDate);
            }

            if ($request->filled('max_date')) {
                $maxDate = $request->input('max_date');
                $outcomeQuery->where('date', '<=', $maxDate);
                $incomeQuery->where('date', '<=', $maxDate);
            }

            $shouldSearchOutcome = true;
            $shouldSearchIncome = true;
        }

        // カテゴリ検索 (OutcomeItem & Income)
        if ($request->filled('selectedCategories')) {
            $selectedCategories = explode(',', $request->input('selectedCategories', ''));

            Log::info($selectedCategories);

            $subCategoryIds = [];
            $incomeCategoryIds = [];

            // "on" を除外
            $selectedCategories = array_filter($selectedCategories, function ($category) {
                return $category !== 'on';
            });

            foreach ($selectedCategories as $category) {
                if (str_starts_with($category, 'outcome-sub-')) {
                    $subCategoryIds[] = str_replace('outcome-sub-', '', $category);
                } elseif (str_starts_with($category, 'income-')) {
                    $incomeCategoryIds[] = str_replace('income-', '', $category);
                }
            }

            if (!empty($subCategoryIds)) {
                // main_category_id と category_id の両方がマッチするデータを取得
                $groupIds = OutcomeItem::whereIn('s_category_id', $subCategoryIds)
                    ->pluck('group_id')
                    ->unique()
                    ->toArray();
                
                if (!$outcomeQuery) {
                    $outcomeQuery = OutcomeGroup::query();
                }
                $outcomeQuery->whereIn('id', $groupIds);
                $shouldSearchOutcome = true;
            }

            // 収入カテゴリの検索
            if (!empty($incomeCategoryIds)) {
                if (!$incomeQuery) {
                    $incomeQuery = Income::query();
                }
                $incomeQuery->whereIn('category_id', $incomeCategoryIds);
                $shouldSearchIncome = true;
            }
        }

        // 品目検索 (OutcomeItem)
        if ($request->filled('item-keyword')) {
            $itemKeyword = $request->input('item-keyword');
            $groupIds = OutcomeItem::where('item', 'like', "%{$itemKeyword}%")
                ->distinct()
                ->pluck('group_id')
                ->toArray();

            $outcomeQuery = OutcomeGroup::query();
            $outcomeQuery->whereIn('id', $groupIds);
            $shouldSearchOutcome = true;
            $shouldSearchIncome = false;
        }

        // お店検索 (OutcomeGroup)
        if ($request->filled('shop-keyword')) {
            $shopKeyword = $request->input('shop-keyword');
            if (!$outcomeQuery) {
                $outcomeQuery = OutcomeGroup::query();
            }
            $outcomeQuery->where('shop', 'like', "%{$shopKeyword}%");
            $shouldSearchOutcome = true;
            $shouldSearchIncome = false;
        }

        // OutcomeGroup の検索結果を取得
        $outcomes = collect();
        if ($shouldSearchOutcome && $outcomeQuery) {
            $outcomes = collect($outcomeQuery->select(
                'id',
                'date',
                'shop',
                'totalPrice as amount',
                'memo',
                'user_id',
                'del_flg'
            )->get()->map(function($item) {
                return (object) [
                    'id' => $item->id,
                    'date' => $item->date,
                    'shop' => $item->shop,
                    'amount' => $item->amount,
                    'memo' => $item->memo,
                    'user_id' => $item->user_id,
                    'del_flg' => $item->del_flg,
                    'category_id' => '-',
                    'name' => '-',
                    'type' => 'outcome',
                ];
            }));
        }

        // Income の検索結果を取得
        $incomes = collect();
        if ($shouldSearchIncome && $incomeQuery) {
            $incomes = $incomeQuery->join('income_categories', 'incomes.category_id', '=', 'income_categories.id')->select(
                'incomes.id',
                'incomes.date',
                'incomes.amount',
                'incomes.category_id',
                'income_categories.name as name',
                'incomes.memo',
                'incomes.user_id',
                'incomes.del_flg'
            )->get()->map(function($item) {
                return (object) [
                    'id' => $item->id,
                    'date' => $item->date,
                    'shop' => '-',
                    'amount' => $item->amount,
                    'memo' => $item->memo,
                    'user_id' => $item->user_id,
                    'del_flg' => $item->del_flg,
                    'category_id' => '-',
                    'name' => $item->name,
                    'type' => 'income',
                ];
            });
        }

        // 検索結果を統合 & ソート
        $totalBalances = $outcomes->merge($incomes)->sortByDesc('date');
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;

        return new LengthAwarePaginator(
            $totalBalances->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $totalBalances->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
