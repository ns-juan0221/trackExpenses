<?php

namespace App\Http\Controllers;

use App\Repositories\OutcomeRepository;
use App\Repositories\IncomeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class MainController extends Controller {
    protected $incomeController;
    protected $outcomeController;

    /**
     * ViewController constructor.
     *
     * @param OutcomeController $outcomeController
     * @param IncomeController $incomeController
     */
    public function __construct(OutcomeController $outcomeController, IncomeController $incomeController) {
        $this->incomeController = $incomeController;
        $this->outcomeController = $outcomeController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $labels = Session::get('labels');
        $lastYearValues = Session::get('lastYearValues');
        $currentYearValues = Session::get('currentYearValues');
        $items = Session::get('items');

        if (is_null($labels) || is_null($lastYearValues) || is_null($currentYearValues)) {
            return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
        }

        return view('main',compact('labels', 'lastYearValues', 'currentYearValues','items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $toggle = request('toggle');
        $groupedOutcomeCategories = Session::get('groupedOutcomeCategories');
        $incomeCategories = Session::get('incomeCategories');

        if (is_null($groupedOutcomeCategories) || is_null($incomeCategories)) {
            return redirect()->route('login')->withErrors(['login_error' => 'ログインが必要です'])->withInput();
        }

        return view('create', compact('groupedOutcomeCategories','incomeCategories','toggle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        if ($request->input('toggle') === 'income') {
            Log::info('incomeControllerに入りました');
            return $this->incomeController->store($request);
        }

        Log::info('outcomeControllerに入りました');
        return $this->outcomeController->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
