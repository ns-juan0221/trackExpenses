<?php

namespace App\Http\Controllers;

use App\Repositories\OutcomeRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OutcomeController extends Controller {
    protected $outcomeRepository;

    /**
     * OutcomeController constructor.
     *
     * @param OutcomeRepository $outcomeRepository
     */
    public function __construct(OutcomeRepository $outcomeRepository) {
        $this->outcomeRepository = $outcomeRepository;
    }

    public function redirectMain() {
        $userId = session('user_id');

        // sessionに$labels,$lastYearValues,$currentYearValues
        $this->showMonthlyHalfYear($userId);
        // sessionに$items
        $this->showSixItem($userId);

        return redirect('/main');
    }

    /**
     * 過去6ヶ月の月ごとの合計を取得
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function showMonthlyHalfYear($userId) {
        $monthlyTotals = $this->outcomeRepository->getMonthlyHalfYear($userId);

        if (empty($monthlyTotals) || count($monthlyTotals) === 0) {

            $this->emptyDataHalfYear();
        }else {

            $this->dataHalfYear($monthlyTotals);
        }
    }

    public function dataHalfYear($monthlyTotals) {
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

        Session::put('labels', $labels);
        Session::put('lastYearValues', $lastYearValues);
        Session::put('currentYearValues', $currentYearValues);
    }

    public function emptyDataHalfYear() {
        $lastYearData = [];
        $currentYearData = [];

        // 最新6か月分
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = (new DateTime())->modify("-$i month");
            $currentYearData[] = [
                'month' => $monthDate->format('Y年n月'),
                'total_sum' => 0
            ];
        }

        // 前年の同じ月
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = (new DateTime())->modify("-$i month")->modify('-1 year');
            $lastYearData[] = [
                'month' => $monthDate->format('Y年n月'),
                'total_sum' => 0
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

        Session::put('labels', $labels);
        Session::put('lastYearValues', $lastYearValues);
        Session::put('currentYearValues', $currentYearValues);
    }

    public function sampleShowMonthlyHalfYear() {

        $this->sampleDataHalfYear();

        // セッションからデータを取得
        $labels = Session::get('labels');
        $lastYearValues = Session::get('lastYearValues');
        $currentYearValues = Session::get('currentYearValues');

        return view('guest', compact('labels', 'lastYearValues', 'currentYearValues'));
    }

    public function sampleDataHalfYear() {
        $lastYearData = [];
        $currentYearData = [];

        // 最新6か月分
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = (new DateTime())->modify("-$i month");
            $currentYearData[] = [
                'month' => $monthDate->format('Y年n月'),
                'total_sum' => rand(1000,10000)
            ];
        }

        // 前年の同じ月
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = (new DateTime())->modify("-$i month")->modify('-1 year');
            $lastYearData[] = [
                'month' => $monthDate->format('Y年n月'),
                'total_sum' => rand(1000,10000)
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

        Session::put('labels', $labels);
        Session::put('lastYearValues', $lastYearValues);
        Session::put('currentYearValues', $currentYearValues);
    }

    public function showSixItem($userId) {
        $items = $this->outcomeRepository->getSixItems($userId);

        Session::put('items', $items);
    }
}
