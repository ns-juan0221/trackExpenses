<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class MainController extends Controller {
    protected $incomeController;
    protected $outcomeController;
    protected $categoryController;
    protected $searchController;

    /**
     * コンストラクタ
     * 
     * @param OutcomeController $outcomeController
     * @param IncomeController $incomeController
     * @param CategoryController $categoryController
     * @param SearchController $searchController
     */
    public function __construct(OutcomeController $outcomeController, IncomeController $incomeController, CategoryController $categoryController, SearchController $searchController) {
        $this->incomeController = $incomeController;
        $this->outcomeController = $outcomeController;
        $this->categoryController = $categoryController;
        $this->searchController = $searchController;
    }

    /**
     * ゲストユーザー用のダッシュボードを表示する
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function guestIndex() {
        $this->outcomeController->getSampleHalfYearGroupsAndLeastItems();
        $labels = Session::get('labels');
        $lastYearValues = Session::get('lastYearValues');
        $currentYearValues = Session::get('currentYearValues');
        $outcomes = collect(Session::get('outcomes'));
        $incomes = collect($this->incomeController->getSampleLeastItems());
        $totalBalances = $incomes->merge($outcomes)->sortByDesc('date')->take(6);

        if (is_null($labels) || is_null($lastYearValues) || is_null($currentYearValues) || is_null($totalBalances)) {
            return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
        }

        return view('guest',compact('labels', 'lastYearValues', 'currentYearValues','totalBalances'));
    }

    /**
     * ユーザーダッシュボードを表示する
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index() {
        $this->outcomeController->getHalfYearGroupsAndLeastItems();
        $labels = Session::get('labels');
        $lastYearValues = Session::get('lastYearValues');
        $currentYearValues = Session::get('currentYearValues');
        $outcomes = collect(Session::get('outcomes'));
        $incomes = collect($this->incomeController->getLeastItems());
        $totalBalances = $incomes->merge($outcomes)->sortByDesc('date')->take(6);

        if (is_null($labels) || is_null($lastYearValues) || is_null($currentYearValues) || is_null($totalBalances)) {
            return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
        }

        return view('main',compact('labels', 'lastYearValues', 'currentYearValues','totalBalances'));
    }

    /**
     * 収支履歴を表示する
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show() {
        $this->categoryController->getCategories();
        $userId = session('user_id');
        $incomes = collect($this->incomeController->getByUserId($userId));
        $outcomes = collect($this->outcomeController->getGroupsByUserId($userId));
        $totalBalances = $incomes->merge($outcomes)->sortByDesc('date');

        $currentPage = request()->input('page', 1);
        $perPage = 10;
        $totalBalances = new LengthAwarePaginator(
            $totalBalances->forPage($currentPage, $perPage),
            $totalBalances->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        $groupedOutcomeCategories = Session::get('groupedOutcomeCategories');
        $incomeCategories = Session::get('incomeCategories');

        if (is_null($groupedOutcomeCategories) || is_null($incomeCategories)) {
            return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
        }

        return view('log', compact('totalBalances','groupedOutcomeCategories','incomeCategories'));
    }

    /**
     * 収支履歴を検索する
     * 
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function search(Request $request) {
        $this->categoryController->getCategories();
        $groupedOutcomeCategories = Session::get('groupedOutcomeCategories');
        $incomeCategories = Session::get('incomeCategories');

        if (is_null($groupedOutcomeCategories) || is_null($incomeCategories)) {
            return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
        }

        $totalBalances = $this->searchController->search($request);

        return view('log', compact('totalBalances','groupedOutcomeCategories','incomeCategories'));
    }

    /**
     * 収支項目の作成ページを表示する
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create() {
        $type = request('type');
        $this->categoryController->getCategories();
        $groupedOutcomeCategories = Session::get('groupedOutcomeCategories');
        $incomeCategories = Session::get('incomeCategories');

        if (is_null($groupedOutcomeCategories) || is_null($incomeCategories)) {
            return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
        }

        return view('registerItem', compact('groupedOutcomeCategories','incomeCategories','type'));
    }

    /**
     * 収支データを保存する
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        if ($request->input('type') === 'income') {
            return $this->incomeController->store($request);
        }

        return $this->outcomeController->store($request);
    }

    /**
     * 収支詳細を表示する
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showDetail(Request $request) {
        $id = $request->input('id');
        $type = $request->input('type');

        if ($type === 'income') {
            $income = $this->incomeController->getById($id);

            return view('logItemDetail', compact('income','type'));
        }else {
            $outcomeItems = $this->outcomeController->getItemsByGroupId($id);
            $outcomeGroup = $this->outcomeController->getGroupByGroupId($id);

            return view('logItemDetail', compact('outcomeItems', 'outcomeGroup', 'type'));
        }
    }

    /**
     * 収支情報を編集するページを表示
     * 
     * @param int $id
     * @param string $type
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(int $id, string $type) {
        if ($type === 'income') {
            $this->categoryController->getIncomeCategories();
            $incomeCategories = Session::get('incomeCategories');

            if (is_null($incomeCategories)) {
                return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
            }

            $income = $this->incomeController->getById($id);
            return view('edit', compact('income','type','incomeCategories'));
        }else {
            $this->categoryController->getOutcomeCategories();
            $groupedOutcomeCategories = Session::get('groupedOutcomeCategories');

            if (is_null($groupedOutcomeCategories)) {
                return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
            }

            $outcomeItems = $this->outcomeController->getItemsByGroupId($id);
            $outcomeGroup = $this->outcomeController->getGroupByGroupId($id);

            $formattedOutcomeGroup = [
                'groupId' => $outcomeGroup->id, // 明示的に groupId を定義
                'date' => $outcomeGroup->date,
                'shop' => $outcomeGroup->shop,
                'totalPrice' => $outcomeGroup->totalPrice,
                'memo' => $outcomeGroup->memo
            ];
            
            return view('edit', compact('outcomeItems','formattedOutcomeGroup','type','groupedOutcomeCategories'));
        }
    }

    /**
     * 収支情報を更新する
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {
        if ($request->input('type') === 'income') {
            return $this->incomeController->update($request);
        }

        return $this->outcomeController->update($request);
    }

    /**
     * 収支情報を削除する
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request) {
        if ($request->type === 'income') {
            return $this->incomeController->destroy($request->id);
        } elseif ($request->type === 'outcome') {
            return $this->outcomeController->destroy($request->id);
        } else {
            return redirect()->route('histories')->with('error', '不正な削除リクエストです。');
        }
    }
}
