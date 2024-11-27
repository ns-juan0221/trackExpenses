@extends('base')
@section('title', 'マネーログ')

@section('content')
<div class="container-fluid">
    <div class="col-8 pe-3">
        <div class="routeDisplay">
            <p class="ms-2 p-1"><a href="{{ route('redirectMain') }}">ホーム</a>  ->  <a href="{{ route('new') }}">入出金入力画面</a></p>
        </div>
        <div class="switch-nav">
            <ul class="d-flex">
                <li class="col-4 outcome {{ !$toggle || $toggle === 'outcome' ? 'active' : '' }}"><a href="{{ route('new', ['toggle' => 'outcome']) }}">支出</a></li>
                <li class="col-4 income {{ $toggle === 'income' ? 'active' : '' }}"><a href="{{ route('new', ['toggle' => 'income']) }}">収入</a></li>
            </ul>
        </div>
        <div class="createBox p-2 mt-2">
            @if($toggle === 'income')
            <!-- 収入フォーム -->
            <form action="" class="formContainer" method="post">
                @csrf
                <div class="formGroup">
                    <div class="formUnit mb-2">
                        <label class="form-label" for="date">日付</label>
                        <input type="text" id="date" class="form-control" name="date" placeholder="日付を入力してください" required>
                    </div>
                    <div class="formUnit mb-2">
                        <label class="form-label" for="amount">金額</label>
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="金額を入力" required>
                    </div>
                    <div class="formUnit mb-2">
                        <label class="form-label" for="category">カテゴリ</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="">カテゴリを選択</option>
                            <option value="food">食費</option>
                            <option value="transport">交通費</option>
                            <option value="entertainment">娯楽</option>
                            <option value="other">その他</option>
                        </select>
                    </div>
                    <div class="formUnit mb-2">
                        <label class="form-label" for="memo">メモ</label>
                        <textarea class="form-control" id="memo" name="memo" rows="3" placeholder="メモを入力"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100">入力する</button>
            </form>
            @else
            <!-- 支出フォーム -->
            <form action="" id="formContainer" method="post">
                @csrf
                <div class="formGroup">
                    <div class="formUnit mb-2">
                        <label class="form-label" for="date">日付</label>
                        <input type="text" id="date" class="form-control" name="date" placeholder="日付を入力してください" required>
                    </div>
                    <div class="formUnit mb-2">
                        <label class="form-label" for="shop">お店</label>
                        <input type="text" id="shop" class="form-control" name="shop" placeholder="お店の名前を入力してください" required>
                    </div>
                    <div id="formListBlock">
                        <div class="formList mb-2 d-flex flex-row">
                            <div class="formUnit form-item col-md-3 me-1">
                                <label class="form-label visually-hidden" for="item">品目</label>
                                <input type="text" id="item" class="form-control item" name="item[]" placeholder="品目" required>
                            </div>
                            <div class="formUnit form-category col-md-3 me-1">
                                <label class="form-label visually-hidden" for="category">カテゴリ</label>
                                <input type="text" id="category" class="form-control category" name="category[]" placeholder="カテゴリ" required>
                            </div>
                            <div class="formUnit form-price col-md-3 me-1">
                                <label class="form-label visually-hidden" for="price">金額</label>
                                <input type="text" id="price" class="form-control price" name="price[]" placeholder="金額" required>
                            </div>
                            <div class="formUnit form-amount col-md-3 me-1">
                                <label class="form-label visually-hidden" for="amount">個数</label>
                                <input type="text" id="amount" class="form-control amount" name="amount[]" placeholder="1" required>
                            </div>
                            <!-- 削除ボタン -->
                            <button type="button" class="btn btn-danger remove-form">削除</button>
                        </div>
                    </div>
                    <div class="text-end">
                        <!-- プラスボタン -->
                        <button type="button" id="add-form" class="btn btn-primary mt-2 mb-2 text-end">＋ フォームを追加</button>
                    </div>
                    <div class="formUnit mb-2">
                        <label class="form-label" for="totalPrice">合計金額</label>
                        <input type="text" id="totalPrice" class="form-control totalPrice" name="totalPrice" required>
                    </div>
                </div>
                <button class="btn btn-success w-100" type="submit">入力する</button>
            </form>
            @endif

        </div>
    </div>
    <div class="col-4 mt-4">
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

<script src="{{ asset('js/expenses-form.js')}}"></script>
<script src="{{ asset('js/calendar.js')}}"></script>
@endsection
