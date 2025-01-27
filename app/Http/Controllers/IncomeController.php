<?php

namespace App\Http\Controllers;

use App\Repositories\IncomeRepository;
use App\Services\IncomeService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class IncomeController extends Controller {
    protected $incomeService;

    /**
     * コンストラクタ
     *
     * @param \App\Services\IncomeService $incomeService
     */
    public function __construct(IncomeService $incomeService) {
        $this->incomeService = $incomeService;
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        try {
            $validator = $this->incomeService->validateIncome($request->all());
            $validator->validate();

            $this->incomeService->createIncome($request->all());

            // 登録後のリダイレクト
            return redirect()->route('getCategoriesToInsert');
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            Log::error('Income creation failed', ['message' => $e->getMessage()]);
            return back()->with('error', 'アイテムの作成に失敗しました。もう一度お試しください。');
        }
    }
}
