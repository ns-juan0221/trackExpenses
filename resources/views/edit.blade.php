@extends('base')
@section('title', '取引の編集')

@section('content')
    <div class="routeDisplay w-100 border-bottom border-2">
        <p class="ms-2 p-1">
            <a href="{{ route('main') }}">ホーム</a>  ->  
            <a href="{{ route('histories') }}">履歴</a>  ->  
            <a href="#" onclick="event.preventDefault(); document.getElementById('detailForm').submit();">履歴詳細</a>  ->  
            @if($type === 'income')
                <a href="{{ route('edit', ['id' => $income->id, 'type' => $type]) }}">編集</a>
            @else
                <a href="{{ route('edit', ['id' => $formattedOutcomeGroup['groupId'], 'type' => $type]) }}">編集</a>
            @endif
            <form id="detailForm" method="POST" action="{{ route('detail') }}" style="display: none;">
                @csrf
                <input type="hidden" name="id" value="{{ $type === 'income' ? $income->id : $formattedOutcomeGroup['groupId'] }}">
                <input type="hidden" name="type" value="{{ $type }}">
            </form>
        </p>
    </div>
    <div class="container-fluid flex-grow-1">
        @if($errors->has('error'))
            <div class="validationError alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif
        <div class="mainArticle d-flex justify-content-center">
            <div class="editForm col-9 mt-3 me-1">
                <div class="editBox p-2">
                    <form action="{{ route('update') }}" class="formContainer needs-validation" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="formGroupBlock">
                            @if ($type === 'income')
                                <input type="hidden" name="id" value="{{ $income->id }}">
                                <div class="form-group">
                                    <label class="form-label" for="inputDate">日付</label>
                                    <input type="text" name="date" id="inputDate" class="form-control" value="{{ old('date', \Carbon\Carbon::parse($income->date)->format('Y/m/d')) }}" required autocomplete="off">
                                    <div class="text-danger dateValidationErrorJs"></div>
                                    @error('date')
                                        <div class="validationError dateValidationError text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label" for="inputAmount">金額</label>
                                    <input type="text" name="amount" id="inputAmount" class="form-control" value="{{ old('amount', floor($income->amount)) }}" required autocomplete="off">
                                    <div class="text-danger amountValidationErrorJs"></div>
                                    @error('date')
                                        <div class="validationError amountValidationError text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label" for="inputCategory">カテゴリ</label>
                                    <select name="category" class="form-control" id="inputCategory" required>
                                        @foreach ($incomeCategories as $incomeCategory)
                                            <option value="category-{{ $incomeCategory->id }}" {{ $income->category_id == $incomeCategory->id ? 'selected' : '' }}>
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
                                    <textarea name="memo" id="inputMemo" class="form-control" rows="3">{{ old('memo', $income->memo) }}</textarea>
                                </div>
                            @else
                                <input type="hidden" name="groupId" value="{{ $formattedOutcomeGroup['groupId'] }}">
                                <div class="form-group">
                                    <label class="form-label" for="inputDate">日付</label>
                                    <input type="text" name="date" id="inputDate" class="form-control" value="{{ old('date', \Carbon\Carbon::parse($formattedOutcomeGroup['date'])->format('Y/m/d')) }}" required autocomplete="off">
                                    <div class="text-danger dateValidationErrorJs"></div>
                                    @error('date')
                                        <div class="validationError dateValidationError text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label" for="inputShop">お店</label>
                                    <input type="text" name="shop" id="inputShop" class="form-control" value="{{ old('shop', $formattedOutcomeGroup['shop']) }}" required autocomplete="off">
                                    <div class="text-danger shopValidationErrorJs"></div>
                                    @error('shop')
                                        <div class="validationError shopValidationError text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="labelList d-flex flex-row mt-2">
                                    <label class="form-label col-3">品目</label>
                                    <label class="form-label col-3">カテゴリ</label>
                                    <label class="form-label col-3">金額</label>
                                    <label class="form-label col-3">個数</label>
                                </div>
                                <div id="formListBlock">
                                    @foreach ($outcomeItems as $index => $item)
                                        <input type="hidden" name="id[]" value="{{ $item->id }}">
                                        <div class="formList d-flex flex-column">
                                            <div class="inputList mb-2 d-flex flex-row">
                                                <div class="form-group form-item col-3 me-1">
                                                    <label class="form-label visually-hidden" for="item-{{ $index }}">品目</label>
                                                    <input type="text" name="item[]" id="item-{{ $index }}" class="form-control item" value="{{ old('item.' . $index, $item->item) }}" required autocomplete="off">
                                                </div>
                                                <div class="form-group form-category col-3 me-1">
                                                    <label class="form-label visually-hidden" for="category-{{ $index }}">カテゴリ</label>
                                                    <select name="category[]" id="category-{{ $index }}" class="form-control category">
                                                        @foreach ($groupedOutcomeCategories as $groupedOutcomeCategory)
                                                            <option value="outcome-main-{{ $groupedOutcomeCategory['main_id'] }}" disabled>
                                                                {{ $groupedOutcomeCategory['main_name'] }}
                                                            </option>
                                                            @foreach ($groupedOutcomeCategory['sub_categories'] as $subCategory)
                                                                <option value="outcome-main-{{ $groupedOutcomeCategory['main_id'] }}|outcome-sub-{{ $subCategory['sub_id'] }}" {{ ($item->m_category_id == $groupedOutcomeCategory['main_id'] && $item->s_category_id == $subCategory['sub_id']) ? 'selected' : '' }}>
                                                                    {{ $subCategory['sub_name'] }}
                                                                </option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-3 me-1">
                                                    <label class="form-label visually-hidden" for="price-{{ $index }}">金額</label>
                                                    <input type="text" name="price[]" id="price-{{ $index }}" class="form-control price" value="{{ old('price.' . $index, floor($item->price)) }}" required autocomplete="off">
                                                </div>
                                                <div class="form-group col-3 me-1">
                                                    <label class="form-label visually-hidden" for="amount-{{ $index }}">個数</label>
                                                    <input type="text" name="amount[]" id="amount-{{ $index }}" class="form-control amount" value="{{ old('amount.' . $index, $item->amount) }}" required autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="errorList">
                                                <div class="formListValidationErrorJs"></div>
                                                <div class="validationError formListValidationError"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="totalPrice">合計金額</label>
                                    <input type="text" id="totalPrice" class="form-control totalPrice" name="totalPrice" value="{{ old('totalPrice', floor($formattedOutcomeGroup['totalPrice'])) }}" required readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label" for="inputMemo">メモ</label>
                                    <textarea name="memo" id="inputMemo" class="form-control" rows="3">{{ old('memo', $formattedOutcomeGroup['memo']) }}</textarea>
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success w-100 mt-2">更新する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($type === 'income')
        <script src="{{ asset('js/incomeFormForEdit.js')}}"></script>
    @else
        <script src="{{ asset('js/outcomeFormForEdit.js')}}"></script>
    @endif
@endsection
