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
     * MainController constructor.
     *
     * @param OutcomeController $outcomeController
     * @param IncomeController $incomeController
     */
    public function __construct(OutcomeController $outcomeController, IncomeController $incomeController, CategoryController $categoryController, SearchController $searchController) {
        $this->incomeController = $incomeController;
        $this->outcomeController = $outcomeController;
        $this->categoryController = $categoryController;
        $this->searchController = $searchController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guestIndex() {
        $this->outcomeController->getSampleHalfYearGroupsAndLeastItems();
        $labels = Session::get('labels');
        $lastYearValues = Session::get('lastYearValues');
        $currentYearValues = Session::get('currentYearValues');
        $items = Session::get('items');

        if (is_null($labels) || is_null($lastYearValues) || is_null($currentYearValues) || is_null($items)) {
            return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
        }

        return view('guest',compact('labels', 'lastYearValues', 'currentYearValues','items'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->outcomeController->getHalfYearGroupsAndLeastItems();
        $labels = Session::get('labels');
        $lastYearValues = Session::get('lastYearValues');
        $currentYearValues = Session::get('currentYearValues');
        $incomes = collect($this->incomeController->getLeastItems());
        $outcomes = collect(Session::get('outcomes'));
        $totalBalances = $incomes->merge($outcomes)->sortByDesc('date')->take(6);

        if (is_null($labels) || is_null($lastYearValues) || is_null($currentYearValues) || is_null($totalBalances)) {
            return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
        }

        return view('main',compact('labels', 'lastYearValues', 'currentYearValues','totalBalances'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

        // dd($totalBalances);
        if (is_null($groupedOutcomeCategories) || is_null($incomeCategories)) {
            return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
        }

        return view('log', compact('totalBalances','groupedOutcomeCategories','incomeCategories'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $this->categoryController->getCategories();
        $groupedOutcomeCategories = Session::get('groupedOutcomeCategories');
        $incomeCategories = Session::get('incomeCategories');

        if (is_null($groupedOutcomeCategories) || is_null($incomeCategories)) {
            return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
        }

        $totalBalances = $this->searchController->search($request);
        // dd($totalBalances);
        return view('log', compact('totalBalances','groupedOutcomeCategories','incomeCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if ($request->input('type') === 'income') {
            return $this->incomeController->store($request);
        }

        return $this->outcomeController->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $type) {
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        if ($request->input('type') === 'income') {
            return $this->incomeController->update($request);
        }

        return $this->outcomeController->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
