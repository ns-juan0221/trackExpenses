<?php

namespace App\Http\Controllers;

use App\Repositories\OutcomeRepository;
use App\Services\OutcomeService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class OutcomeController extends Controller {
    protected $outcomeService;
    protected $outcomeRepository;

    /**
     * コンストラクタ
     * 
     * @param OutcomeService $outcomeService
     * @param OutcomeRepository $outcomeRepository
     */
    public function __construct(OutcomeService $outcomeService, OutcomeRepository $outcomeRepository) {
        $this->outcomeService = $outcomeService;
        $this->outcomeRepository = $outcomeRepository;
    }

    /**
     * 支出データを保存する
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
            
            return $this->outcomeService->createOutcome($groupData, $itemsData);
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            Log::error('Outcome creation failed', ['message' => $e->getMessage()]);
            return back()->with('error', 'アイテムの作成に失敗しました。もう一度お試しください。');
        }
    }

    /**
     * 支出データを更新する
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {
        try {
            $validator = $this->outcomeService->validateOutcome($request->all());
            $validator->validate();

            $groupData = [
                'id' => $request['groupId'],
                'date' => $request['date'],
                'shop' => $request['shop'],
                'totalPrice' => $request['totalPrice'],
                'memo' => $request['memo'],
            ];

            $itemsData = $this->outcomeService->prepareUpdatedItemsData($request->all());
            
            return $this->outcomeService->updateOutcome($groupData, $itemsData);
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

    /**
     * 支出データを削除する
     *
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id) {
        return $this->outcomeService->destroyOutcome($id);
    }

    /**
     * ユーザーIDから支出グループデータを取得する
     *
     * @param int $userId
     * @return mixed
     */
    public function getGroupsByUserId(int $userId) {
        return $this->outcomeRepository->getGroupsByUserId($userId);
    }

    /**
     * 支出グループIDから支出アイテムデータを取得する
     *
     * @param int $groupId
     * @return mixed
     */
    public function getItemsByGroupId(int $groupId) {
        $userId = session('user_id');
        return $this->outcomeRepository->getItemsByGroupId($userId,$groupId);
    }

    /**
     * 支出グループIDから支出グループデータを取得する
     *
     * @param int $groupId
     * @return mixed
     */
    public function getGroupByGroupId(int $groupId) {
        $userId = session('user_id');
        return $this->outcomeRepository->getGroupByGroupId($userId,$groupId);
    }

    /**
     * 過去半年間の支出グループデータと最近の支出アイテムデータを取得する
     *
     * @return void
     */
    public function getHalfYearGroupsAndLeastItems() {
        $userId = session('user_id');

        $this->getHalfYearGroups($userId);
        $this->getLeastItems($userId);
    }

    /**
     * サンプルユーザー（ID:1）で過去半年間の支出グループデータと最近の支出アイテムデータを取得する
     *
     * @return void
     */
    public function getSampleHalfYearGroupsAndLeastItems() {
        $userId = 1;

        $this->getHalfYearGroups($userId);
        $this->getLeastItems($userId);
    }

    /**
     * 過去半年間の支出グループデータを取得し、フォーマットする
     *
     * @param int $userId
     * @return void
     */
    public function getHalfYearGroups(int $userId) {
        $monthlyTotals = $this->outcomeRepository->getMonthlyHalfYear($userId);

        if (empty($monthlyTotals) || count($monthlyTotals) === 0) {
            $this->getEmptyHalfYearGroupsAndFormatData();
        }else {
            $this->getHalfYearGroupsAndFormatData($monthlyTotals);
        }
    }

    /**
     * 過去半年間のデータをフォーマットする
     *
     * @param array $monthlyTotals
     * @return void
     */
    public function getHalfYearGroupsAndFormatData($monthlyTotals) {
        $labels = [];
        $lastYearValues = [];
        $currentYearValues = [];
    
        $startMonth = Carbon::now()->subMonths(5)->startOfMonth();  
        $endMonth = Carbon::now()->startOfMonth();
    
        $totalsMap = [];
        foreach ($monthlyTotals as $group) {
            $totalsMap[$group->month] = $group->total_sum;
        }
    
        while ($startMonth <= $endMonth) {
            $isLastLoop = $startMonth->eq($endMonth);
            $lastYearLabel = $startMonth->copy()->subYear()->format('Y年m月');
            $currentYearLabel = $startMonth->format('Y年m月');
    
            $labels[] = $lastYearLabel;
            $labels[] = $currentYearLabel;
    
            if (!$isLastLoop) {
                $labels[] = "";
            }
    
            $lastYearValues[] = $totalsMap[$lastYearLabel] ?? null;
            $lastYearValues[] = null;

            if (!$isLastLoop) {
                $lastYearValues[] = null;
            }
    
            $currentYearValues[] = null;
            $currentYearValues[] = $totalsMap[$currentYearLabel] ?? null;

            if (!$isLastLoop) {
                $currentYearValues[] = null;
            }
    
            $startMonth->addMonth();
        }

        Session::put('labels', $labels);
        Session::put('lastYearValues', $lastYearValues);
        Session::put('currentYearValues', $currentYearValues);
    }    

    /**
     * 過去半年間の空のデータをフォーマットする
     *
     * @return void
     */
    public function getEmptyHalfYearGroupsAndFormatData() {
        $lastYearData = [];
        $currentYearData = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = (new DateTime())->modify("-$i month");
            $currentYearData[] = [
                'month' => $monthDate->format('Y年n月'),
                'total_sum' => 0
            ];
        }

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = (new DateTime())->modify("-$i month")->modify('-1 year');
            $lastYearData[] = [
                'month' => $monthDate->format('Y年n月'),
                'total_sum' => 0
            ];
        }

        $labels = [];
        $currentYearValues = [];
        $lastYearValues = [];

        for ($i = 0; $i < 6; $i++) {
            $labels[] = $lastYearData[$i]['month'];
            $labels[] = $currentYearData[$i]['month'];
            $labels[] = '';

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

    /**
     * ユーザーIDから最近の支出アイテムデータを取得する
     *
     * @param int $userId
     * @return void
     */
    public function getLeastItems(int $userId) {
        $outcomes = $this->outcomeRepository->getRepresentativeItemsByUserId($userId);

        Session::put('outcomes', $outcomes);
    }
}
