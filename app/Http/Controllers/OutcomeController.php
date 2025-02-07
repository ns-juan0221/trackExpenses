<?php

namespace App\Http\Controllers;

use App\Models\OutcomeItem;
use App\Services\OutcomeService;
use App\Repositories\OutcomeRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OutcomeController extends Controller {
    protected $outcomeService;
    protected $outcomeRepository;

    /**
     * コンストラクタ
     *
     * @param \App\Services\OutcomeService $outcomeService
     * @param \App\Repositories\OutcomeRepository $outcomeRepository
     */
    public function __construct(OutcomeService $outcomeService, OutcomeRepository $outcomeRepository) {
        $this->outcomeService = $outcomeService;
        $this->outcomeRepository = $outcomeRepository;
    }

    public function getGroupsByUserId($userId) {
        return $this->outcomeRepository->getGroupsByUserId($userId);
    }

    public function getItemsByGroupId($groupId) {
        $userId = session('user_id');
        return $this->outcomeRepository->getItemsByGroupId($userId,$groupId);
    }
    
    public function getGroupByGroupId($groupId) {
        $userId = session('user_id');
        return $this->outcomeRepository->getGroupByGroupId($userId,$groupId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        try {
            $validator = $this->outcomeService->validateOutcome($request->all());
            $validator->validate();

            $groupData = [
                'user_id' => session('user_id'),
                'date' => $request['date'],
                'shop' => $request['shop'],
                'totalPrice' => $request['totalPrice'],
                'memo' => $request['memo'],
            ];

            $itemsData = $this->outcomeService->prepareItemsData($request->all());
            $this->outcomeService->createOutcome($groupData, $itemsData);

            // 登録後のリダイレクト
            return redirect()->route('new');
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            Log::error('Outcome creation failed', ['message' => $e->getMessage()]);
            return back()->with('error', 'アイテムの作成に失敗しました。もう一度お試しください。');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        try {
            $validator = $this->outcomeService->validateOutcome($request->all());
            $validator->validate();
            Log::info('validate passed');

            $groupData = [
                'id' => $request['groupId'],
                'date' => $request['date'],
                'shop' => $request['shop'],
                'totalPrice' => $request['totalPrice'],
                'memo' => $request['memo'],
            ];

            $itemsData = $this->outcomeService->prepareItemsData($request->all());
            Log::info('prepareItemsData() passed');
            $this->outcomeService->updateOutcome($groupData, $itemsData);

            // 登録後のリダイレクト
            return redirect()->route('histories');
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);

            return redirect()->route('edit', ['id' => $request['groupId'], 'type' => $request['type']])
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Throwable $e) {
            Log::error('Outcome update failed', ['message' => $e->getMessage()]);

            return redirect()->route('edit', ['id' => $request['groupId'], 'type' => $request['type']])
            ->withInput()
            ->with('error', 'アイテムの更新に失敗しました。もう一度お試しください。');
        }
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
