<?php

namespace App\Http\Controllers;

use App\Repositories\OutcomeRepository;
use App\Repositories\IncomeRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ViewController extends Controller {
    protected $outcomeRepository;
    protected $incomeRepository;

    /**
     * ViewController constructor.
     *
     * @param OutcomeRepository $outcomeRepository
     * @param IncomeRepository $incomeRepository
     */
    public function __construct(OutcomeRepository $outcomeRepository,IncomeRepository $incomeRepository) {
        $this->outcomeRepository = $outcomeRepository;
        $this->incomeRepository = $incomeRepository;
    }

    public function index() {
        $groupedOutcomeCategories = Session::get('groupedOutcomeCategories');

        if (is_null($groupedOutcomeCategories)) {
            return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
        }

        return view('log',compact('groupedOutcomeCategories'));
    }

    public function getHalfYearGroupsAndLeastItemsToRedirectMain() {
        $userId = session('user_id');

        // sessionに$labels,$lastYearValues,$currentYearValues
        $this->getHalfYearGroups($userId);
        // sessionに$items
        $this->getLeastItems($userId);

        return app(MainController::class)->index();
    }

    public function getSampleHalfYearGroupsAndLeastItems() {
        $userId = 1;

        // sessionに$labels,$lastYearValues,$currentYearValues
        $this->getHalfYearGroups($userId);
        // sessionに$items
        $this->getLeastItems($userId);

        $labels = Session::get('labels');
        $lastYearValues = Session::get('lastYearValues');
        $currentYearValues = Session::get('currentYearValues');
        $items = Session::get('items');

        return view('guest',compact('labels', 'lastYearValues', 'currentYearValues','items'));
    }

    public function getHalfYearGroups($userId) {
        $monthlyTotals = $this->outcomeRepository->getMonthlyHalfYear($userId);

        if (empty($monthlyTotals) || count($monthlyTotals) === 0) {

            $this->getEmptyHalfYearGroupsAndFormatData();
        }else {

            $this->getHalfYearGroupsAndFormatData($monthlyTotals);
        }
    }

    public function getHalfYearGroupsAndFormatData($monthlyTotals) {
        $labels = [];
        $lastYearValues = [];
        $currentYearValues = [];

        // 対象月の範囲を決定
        $startMonth = Carbon::now()->subMonths(5)->startOfMonth();  
        $endMonth = Carbon::now()->startOfMonth();

        // 月ごとにループ
        while ($startMonth <= $endMonth) {
            $isLastLoop = $startMonth->eq($endMonth);
            $lastYearLabel = $startMonth->copy()->subYear()->format('Y年m月');
            $currentYearLabel = $startMonth->format('Y年m月');

            // ラベル追加
            $labels[] = $lastYearLabel;
            $labels[] = $currentYearLabel;

            if (!$isLastLoop) {
                $labels[] = "";
            }

            foreach ($monthlyTotals as $group) {
                if ($group->month === $lastYearLabel) {
                    $lastYearValues[] = $group->total_sum;
                    $lastYearValues[] = null;

                    if (!$isLastLoop) {
                        $lastYearValues[] = null;
                    }
                }
                if ($group->month === $currentYearLabel) {
                    $currentYearValues[] = null;
                    $currentYearValues[]  = $group->total_sum;
                    
                    if (!$isLastLoop) {
                        $currentYearValues[] = null;
                    }
                }
            }
            $startMonth->addMonth();
        }

        Session::put('labels', $labels);
        Session::put('lastYearValues', $lastYearValues);
        Session::put('currentYearValues', $currentYearValues);
    }

    public function getEmptyHalfYearGroupsAndFormatData() {
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

    public function getLeastItems($userId) {
        $items = $this->outcomeRepository->getSixItems($userId);

        Session::put('items', $items);
    }
}
