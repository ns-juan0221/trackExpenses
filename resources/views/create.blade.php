@extends('base')
@section('title', 'マネーログ')

@section('content')
    <div class="routeDisplay w-100 border-bottom border-2">
        <p class="ms-2 p-1">
            <a href="{{ route('main') }}">ホーム</a>  ->  <a href="{{ route('new') }}">入力</a>
        </p>
    </div>
    <div class="container-fluid flex-grow-1">
        <div class="mainArticle d-flex justify-content-center">
            <div class="createForm col-8 mt-4 me-1">
                <div class="switch-nav">
                    <ul class="d-flex">
                        <li class="col-4 outcome {{ !$type || $type === 'outcome' ? 'active' : '' }} me-2"><a href="{{ route('new', ['type' => 'outcome']) }}">支出</a></li>
                        <li class="col-4 income {{ $type === 'income' ? 'active' : '' }}"><a href="{{ route('new', ['type' => 'income']) }}">収入</a></li>
                    </ul>
                </div>

                <script>
                    // BladeからデータをJavaScriptのグローバル変数に渡す
                    window.groupedOutcomeCategories = @json($groupedOutcomeCategories);
                </script>
                
                <div class="createBox p-2">
                    <form action="{{ route('store') }}" class="formContainer needs-validation" method="post">
                        @csrf
                        <input type="hidden" name="type" value="{{ request('type') }}">
                        <div class="formGroupBlock">
                            <div class="form-group">
                                <label class="form-label" for="inputDate">日付</label>
                                <input type="text" name="date" id="inputDate" class="form-control" placeholder="日付を入力してください" value="{{ $errors->has('date') ? '' : old('date') }}" required autocomplete="off">
                                <div class="text-danger dateValidationErrorJs"></div>
                                @error('date')
                                    <div class="validationError dateValidationError text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @if($type === 'income')
                                <div class="form-group mt-2">
                                    <label class="form-label" for="inputAmount">金額</label>
                                    <input type="text" name="amount" id="inputAmount" class="form-control" placeholder="金額を入力してください" value="{{ $errors->has('amount') ? '' : old('amount') }}" required autocomplete="off">
                                    <div class="text-danger amountValidationErrorJs"></div>
                                    @error('date')
                                        <div class="validationError amountValidationError text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label" for="inputCategory">カテゴリ</label>
                                    <select name="category" class="form-control" id="inputCategory" required>
                                        <option value="default" selected>カテゴリを選択してください</option>
                                        @foreach ($incomeCategories as $incomeCategory)
                                            <option value="category-{{ $incomeCategory->id }}" {{ old('category') == "category-$incomeCategory->id" ? 'selected' : ''}}>
                                                {{ $incomeCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="validationError categoryValidationError text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label" for="inputMemo">メモ</label>
                                    <textarea name="memo" id="inputMemo" class="form-control" placeholder="メモを入力してください" value="{{ $errors->has('memo') ? '' : old('memo') }}" rows="3"></textarea>
                                </div>
                            @else
                                <div class="form-group mt-2">
                                    <label class="form-label" for="inputShop">お店</label>
                                    <input type="text" name="shop" id="inputShop" class="form-control" placeholder="お店の名前を入力してください" value="{{ $errors->has('shop') ? '' : old('shop') }}" required autocomplete="off">
                                    <div class="text-danger shopValidationErrorJs"></div>
                                    @error('shop')
                                        <div class="validationError shopValidationError text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="formListBlock" class="mt-2">
                                    @foreach (old('item', ['']) as $index => $oldItem)
                                        <div class="formList d-flex flex-column">
                                            <div class="inputList mb-2 d-flex flex-row">
                                                <div class="form-group form-item col-md-3 me-1">
                                                    <label class="form-label visually-hidden" for="item-{{ $index }}">品目</label>
                                                    <input type="text" name="item[]" id="item-{{ $index }}" class="form-control item" placeholder="商品名" value="{{ $oldItem }}" required autocomplete="off">
                                                </div>
                                                <div class="form-group form-category col-md-3 me-1">
                                                    <label class="form-label visually-hidden" for="category-{{ $index }}">カテゴリ</label>
                                                    <select name="category[]" id="category-{{ $index }}" class="form-control category" >
                                                        @foreach ($groupedOutcomeCategories as $groupedOutcomeCategory)
                                                            <option value="outcome-main-{{ $groupedOutcomeCategory['main_id'] }}" disabled>
                                                                {{ $groupedOutcomeCategory['main_name'] }}
                                                            </option>
                                                            @foreach ($groupedOutcomeCategory['sub_categories'] as $subCategory)
                                                                <option value="outcome-main-{{ $groupedOutcomeCategory['main_id'] }}|outcome-sub-{{ $subCategory['sub_id'] }}" {{ old('category' . $index) == "outcome-main-{$groupedOutcomeCategory['main_id']} | outcome-sub-{$subCategory['sub_id']}" ? 'selected' : ''}}>
                                                                    {{ $subCategory['sub_name'] }}
                                                                </option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>                                
                                                </div>
                                                <div class="form-group form-price col-md-3 me-1">
                                                    <label class="form-label visually-hidden" for="price-{{ $index }}">金額</label>
                                                    <input type="text" name="price[]" id="price-{{ $index }}" class="form-control price" placeholder="金額" value="{{ old('price.' . $index) }}" required autocomplete="off">
                                                </div>
                                                <div class="form-group form-amount col-md-3 me-1">
                                                    <label class="form-label visually-hidden" for="amount-{{ $index }}">個数</label>
                                                    <input type="text" name="amount[]" id="amount-{{ $index }}" class="form-control amount" placeholder="1" value="{{ old('amount' . $index) }}" required autocomplete="off">
                                                </div>
                                                <!-- 削除ボタン -->
                                                <button type="button" class="btn btn-danger remove-form">削除</button>
                                            </div>
                                            <div class="errorList">
                                                <div class="formListValidationErrorJs"></div>
                                                <div class="validationError formListValidationError"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-end">
                                    <!-- プラスボタン -->
                                    <button type="button" id="add-form" class="btn btn-primary mt-2 mb-2 text-end">＋ フォームを追加</button>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="totalPrice">合計金額</label>
                                    <input type="text" id="totalPrice" class="form-control totalPrice" name="totalPrice" required readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label" for="inputMemo">メモ</label>
                                    <textarea name="memo" id="inputMemo" class="form-control" placeholder="メモを入力してください" value="{{ $errors->has('memo') ? '' : old('memo') }}" rows="3"></textarea>
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success w-100 mt-2">入力する</button>
                    </form>
                </div>
            </div>
            <div class="calendar col-4 mt-4 ms-1">
                <div class="calendarTitle text-center">
                    <button onclick="prevMonth()"><img src="{{ asset('images/left.png') }}" height="20" width="20"></button>
                    <span id="currentMonthYear"></span>
                    <button onclick="nextMonth()"><img src="{{ asset('images/right.png') }}" height="20" width="20"></button>
                </div>
                <div class="calendarContainer">
                    <table class="calendarTable">
                        <thead>
                            <tr>
                                <th>日</th>
                                <th>月</th>
                                <th>火</th>
                                <th>水</th>
                                <th>木</th>
                                <th>金</th>
                                <th>土</th>
                            </tr>
                        </thead>
                        <tbody id="calendarBody">
                            <!-- 1ヶ月目のカレンダーがJSで生成されます -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if($type === 'income')
        <script src="{{ asset('js/incomeFormForCreate.js')}}"></script>
    @else
        <script src="{{ asset('js/outcomeFormForCreate.js')}}"></script>
    @endif
    <script src="{{ asset('js/calendar.js')}}"></script>
@endsection
