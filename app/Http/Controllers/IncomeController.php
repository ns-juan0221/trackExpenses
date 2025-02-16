<?php

namespace App\Http\Controllers;

use App\Repositories\IncomeRepository;
use App\Services\IncomeService;
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
     * @param IncomeService $incomeService
     * @param IncomeRepository $incomeRepository
     */
    public function __construct(IncomeService $incomeService, IncomeRepository $incomeRepository) {
        $this->incomeService = $incomeService;
        $this->incomeRepository = $incomeRepository;
    }

    /**
     * 収入データを保存する
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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

    /**
     * 収入データを更新する
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * 収入データを削除する
     * 
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id) {
        return $this->incomeService->destroyIncome($id);
    }

    /**
     * ユーザーIDから収入データを取得する
     * 
     * @param int $userId
     * @return mixed
     */
    public function getByUserId(int $userId) {
        return $this->incomeRepository->getByUserId($userId);
    }

    /**
     * IDから収入データを取得する
     * 
     * @param int $id
     * @return mixed
     */
    public function getById(int $id) {
        $userId = session('user_id');
        return $this->incomeRepository->getById($id,$userId);
    }

    /**
     * 最近の収入データを取得する
     * 
     * @return mixed
     */
    public function getLeastItems() {
        $userId = session('user_id');
        return $this->incomeRepository->getRepresentativeItemsByUserId($userId);
    }

    /**
     * サンプル用の最近の収入データを取得する
     * 
     * @return mixed
     */
    public function getSampleLeastItems() {
        $userId = 1;
        return $this->incomeRepository->getRepresentativeItemsByUserId($userId);
    }
}
