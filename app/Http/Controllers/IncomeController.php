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
    protected $incomeRepository;

    /**
     * コンストラクタ
     *
     * @param \App\Services\IncomeService $incomeService
     * @param \App\Repositories\IncomeRepository $incomeRepository
     */
    public function __construct(IncomeService $incomeService, IncomeRepository $incomeRepository) {
        $this->incomeService = $incomeService;
        $this->incomeRepository = $incomeRepository;
    }

    public function getByUserId(int $userId) {
        return $this->incomeRepository->getByUserId($userId);
    }

    public function getById(int $id) {
        $userId = session('user_id');
        return $this->incomeRepository->getById($id,$userId);
    }

    public function getLeastItems() {
        $userId = session('user_id');
        return $this->incomeRepository->getRepresentativeItemsByUserId($userId);
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
            return redirect()->route('register')->with('success', 'データを作成しました。');
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            Log::error('Income creation failed', ['message' => $e->getMessage()]);
            return back()->with('error', 'アイテムの作成に失敗しました。もう一度お試しください。');
        }
    }

    public function update(Request $request) {
        try {
            $validator = $this->incomeService->validateIncome($request->all());
            $validator->validate();

            return $this->incomeService->updateIncome($request->all());
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            Log::error('Income creation failed', ['message' => $e->getMessage()]);
            return back()->with('error', 'アイテムの作成に失敗しました。もう一度お試しください。');
        }
    }

    public function destroy($id) {
        return $this->incomeService->destroyIncome($id);
    }
}
