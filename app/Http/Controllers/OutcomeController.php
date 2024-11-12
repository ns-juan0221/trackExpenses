<?php

namespace App\Http\Controllers;

use App\Repositories\OutcomeRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OutcomeController extends Controller
{
    protected $outcomeRepository;

    /**
     * OutcomeController constructor.
     *
     * @param OutcomeRepository $outcomeRepository
     */
    public function __construct(OutcomeRepository $outcomeRepository)
    {
        $this->outcomeRepository = $outcomeRepository;
    }

    /**
     * 過去6ヶ月の月ごとの合計を取得
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function showMonthlyHalfYear($userId)
    {
        Log::info('showMonthlyTotalsメソッドに入りました');
        $monthlyTotals = $this->outcomeRepository->getMonthlyHalfYear($userId);

        if (empty($monthlyTotals) || count($monthlyTotals) === 0) {
            // ログにエラーメッセージを出力
            Log::info('Monthly Totalsが空、もしくは、空配列です');

            $lastYearData = [];
            $currentYearData = [];

            // 最新6か月分
            for ($i = 5; $i >= 0; $i--) {
                $monthDate = (new DateTime())->modify("-$i month");
                $currentYearData[] = [
                    'month' => $monthDate->format('Y年n月'),
                    'total_sum' => rand(20000, 40000)  // ランダムな支出額（サンプルデータ）
                ];
            }

            // 前年の同じ月
            for ($i = 5; $i >= 0; $i--) {
                $monthDate = (new DateTime())->modify("-$i month")->modify('-1 year');
                $lastYearData[] = [
                    'month' => $monthDate->format('Y年n月'),
                    'total_sum' => rand(20000, 40000)  // ランダムな支出額（サンプルデータ）
                ];
            }

            // JavaScriptで使いやすい形式に整形
            $labels = [];
            $currentYearValues = [];
            $lastYearValues = [];

            for ($i = 0; $i < 6; $i++) {
                $labels[] = $lastYearData[$i]['month'];
                $labels[] = $currentYearData[$i]['month'];
                $labels[] = '';  // 空のラベルを追加

                $lastYearValues[] = $lastYearData[$i]['total_sum'];
                $lastYearValues[] = null;
                $lastYearValues[] = null;

                $currentYearValues[] = null;
                $currentYearValues[] = $currentYearData[$i]['total_sum'];
                $currentYearValues[] = null;
            }

            Log::info('自動生成されたMonthly Totals:', compact('labels', 'lastYearValues', 'currentYearValues'));

        }else {
            $labels = [];
            $lastYearValues = [];
            $currentYearValues = [];

            // 対象月の範囲を決定
            $startMonth = Carbon::now()->subMonths(5)->startOfMonth();  // 5ヶ月前の月初
            $endMonth = Carbon::now();  // 現在の月（2024年11月）


            // 月ごとにループ
            while ($startMonth <= $endMonth) {
                $lastYearLabel = $startMonth->copy()->subYear()->format('Y年m月');
                $currentYearLabel = $startMonth->format('Y年m月');

                // ラベル追加
                $labels[] = $lastYearLabel;
                $labels[] = $currentYearLabel;
                $labels[] = "";  // 空のラベル

                // 昨年と今年のデータを初期化
                $lastYearData = null;
                $currentYearData = null;

                // データを探して割り当て
                foreach ($monthlyTotals as $group) {
                    if ($group->month === $lastYearLabel) {
                        $lastYearValues[] = $group->total_sum;
                        $lastYearValues[] = null;  // 空のデータ
                        $lastYearValues[] = null;  // 空のデータ

                    }
                    if ($group->month === $currentYearLabel) {
                        $currentYearValues[] = null;  // 空のデータ
                        $currentYearValues[]  = $group->total_sum;
                        $currentYearValues[] = null;  // 空のデータ
                    }
                }

                // 次の月に進む
                $startMonth->addMonth();
            }
            Log::info($lastYearValues);
            Log::info($currentYearValues);
        }

        return view('main', compact('labels', 'lastYearValues', 'currentYearValues', 'userId'));
    }

    public function sampleShowMonthlyHalfYear(){
        $lastYearData = [];
            $currentYearData = [];

            // 最新6か月分
            for ($i = 5; $i >= 0; $i--) {
                $monthDate = (new DateTime())->modify("-$i month");
                $currentYearData[] = [
                    'month' => $monthDate->format('Y年n月'),
                    'total_sum' => rand(20000, 40000)  // ランダムな支出額（サンプルデータ）
                ];
            }

            // 前年の同じ月
            for ($i = 5; $i >= 0; $i--) {
                $monthDate = (new DateTime())->modify("-$i month")->modify('-1 year');
                $lastYearData[] = [
                    'month' => $monthDate->format('Y年n月'),
                    'total_sum' => rand(20000, 40000)  // ランダムな支出額（サンプルデータ）
                ];
            }

            // JavaScriptで使いやすい形式に整形
            $labels = [];
            $currentYearValues = [];
            $lastYearValues = [];

            for ($i = 0; $i < 6; $i++) {
                $labels[] = $lastYearData[$i]['month'];
                $labels[] = $currentYearData[$i]['month'];
                $labels[] = '';  // 空のラベルを追加

                $lastYearValues[] = $lastYearData[$i]['total_sum'];
                $lastYearValues[] = null;
                $lastYearValues[] = null;

                $currentYearValues[] = null;
                $currentYearValues[] = $currentYearData[$i]['total_sum'];
                $currentYearValues[] = null;
            }

            return view('guest', compact('labels', 'lastYearValues', 'currentYearValues'));
    }
}
