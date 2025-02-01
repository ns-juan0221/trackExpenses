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

    public function getGroupsByUserId($id) {
        return $this->outcomeRepository->getGroupsByUserId($id);
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
}
