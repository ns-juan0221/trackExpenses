<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller {
    protected $userService;

    /**
     * コンストラクタ
     * 
     * @param UserService $userService
     */
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * 新規ユーザー登録画面を表示する
     * 
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('newUser');
    }

    /**
     * 新規ユーザーを作成する
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        try {
            $validator = $this->userService->validateUser($request->all());
            $validator->validate();

            $user = $this->userService->createUser($request->all());

            // ユーザー登録イベントの発火
            event(new Registered($user));

            auth()->login($user);

            session(['user_id' => auth()->id()]);

            return redirect()->route('main');
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);

            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            Log::error('User creation failed', ['message' => $e->getMessage()]);

            return back()->with('error', 'ユーザーの作成に失敗しました。もう一度お試しください。');
        }
    }
}
