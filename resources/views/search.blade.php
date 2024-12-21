@extends('base')
@section('title', 'マネーログ')

@section('content')
    <div class="container-fluid flex-grow-1">
        <div class="routeDisplay w-100">
            <p class="ms-2 p-1">
                <a href="{{ route('getHalfYearGroupsAndLeastItems') }}">ホーム</a> -> <a href="{{ route('getCategoriesToSearch') }}">検索画面</a>
            </p>
        </div>
        <div class="searchBox">
            <form action="/view" class="formContainer p-2 align-items-center d-flex flex-column" method="post">
                @csrf
                <div class="formGroup">
                    <table class="searchTable">
                        <tbody>
                            <tr>
                                <td class="keywordLabelList" rowspan="3">
                                    <div class="searchLabel">
                                        <p>キーワード</p>
                                    </div>
                                </td>
                                <td class="keywordLabel itemLabel">
                                    <div class="searchLabel">
                                        <p>品目</p>
                                    </div>
                                </td>
                                <td class="itemKeywordInput">
                                    <div class="formUnit d-flex">
                                        <input type="text" name="item-keyword" id="item-keyword" class="form-control" placeholder="検索キーワードを入力" value="" autocomplete="off" autofocus="" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="keywordLabel shopLabel">
                                    <div class="searchLabel">
                                        <p>お店</p>
                                    </div>
                                </td>
                                <td class="shopKeywordInput">
                                    <div class="formUnit d-flex">
                                        <input type="text" name="shop-keyword" id="shop-keyword" class="form-control" placeholder="検索キーワードを入力" value="" autocomplete="off" autofocus="" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="keywordLabel memoLabel">
                                    <div class="searchLabel">
                                        <p>メモ</p>
                                    </div>
                                </td>
                                <td class="memoKeywordInput">
                                    <div class="formUnit d-flex">
                                        <input type="text" name="memo-keyword" id="memo-keyword" class="form-control" placeholder="検索キーワードを入力" value="" autocomplete="off" autofocus="" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="priceLabel" colspan="2">
                                    <div class="searchLabel">
                                        <p>金額</p>
                                    </div>
                                </td>
                                <td class="priceInput">
                                    <div class="formUnit d-flex flex-row align-items-center">
                                        <div class="form-price me-1">
                                            <input type="text" name="min_price" id="minPrice" class="form-control" value="" placeholder="" autofocus="" />
                                            <div class="yen">¥</div>
                                        </div>
                                        <span class="from-to">～</span>
                                        <div class="form-price me-1">
                                            <input type="text" name="max_price" id="maxPrice" class="form-control" value="" placeholder="" autofocus="" />
                                            <div class="yen">¥</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="dateLabel" colspan="2">
                                    <div class="searchLabel">
                                        <p>日付</p>
                                    </div>
                                </td>
                                <td class="dateInput">
                                    <div class="formUnit d-flex flex-row align-items-center">
                                        <div class="form-date me-1">
                                            <input type="text" name="min_date" id="minDate" class="form-control" value="" placeholder="" autofocus="" />
                                        </div>
                                        <span class="from-to">～</span>
                                        <div class="form-date me-1">
                                            <input type="text" name="max_date" id="maxDate" class="form-control" value="" placeholder="" autofocus="" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="categoryLabel" colspan="2">
                                    <div class="searchLabel">
                                        <p>カテゴリ</p>
                                    </div>
                                </td>
                                <td class="categoryInput">
                                    <div class="formUnit d-flex flex-column">

                                        <script>
                                            // BladeからデータをJavaScriptのグローバル変数に渡す
                                            window.groupedCategories = @json($groupedCategories);
                                        </script>

                                        <div class="categorySelectBtn w-100">
                                            <button type="button" class="btn btn-success" onclick="openModal()">カテゴリを選択</button>
                                            <button type="button" class="btn btn-light" onclick="clearSelection()">選択をクリア</button>
                                        </div>
                                        <div id="selected-categories" class="selected-categories-container"></div>

                                        <!-- モーダル -->
                                        <div class="modal fade" id="categoryModal">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">カテゴリを選択</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- 検索バー -->
                                                        <input type="text" id="searchBar" class="form-control mb-3" placeholder="カテゴリを検索">
                                                        <!-- カテゴリリスト -->
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="global-category-checkbox">
                                                            <label class="form-check-label" for="global-category-checkbox">全カテゴリを選択</label>
                                                        </div>
                                                        <div id="categoriesList"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                                        <button type="button" class="btn btn-primary" onclick="saveSelection()">保存</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="displayFormatLabel" colspan="2">
                                    <div class="searchLabel">
                                        <p>表示形式</p>
                                    </div>
                                </td>
                                <td class="displayFormatInput">
                                    <div class="formUnit d-flex">
                                        <ul class="searchResultDisplayFormat">
                                            <li class="DisplayFormat-li">
                                                <div class="checkbox">
                                                    <label for="searchResultGroup"></label>
                                                    <input id="searchResultGroup" name="displayFormat" value="group" type="radio" checked="checked">
                                                </div>
                                                <div class="DisplayFormatText">
                                                    <label for="searchResultGroup">グループ毎</label>
                                                </div>
                                            </li>
                                            <li class="DisplayFormat-li">
                                                <div class="checkbox">
                                                    <label for="searchResultItem"></label>
                                                    <input id="searchResultItem" name="displayFormat" value="item" type="radio">
                                                </div>
                                                <div class="DisplayFormatText">
                                                    <label for="searchResultItem">アイテム毎</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="formBtnGroup">
                    <button type="button" class="btn btn-light" id="resetBtn">指定した条件をクリア</button>
                    <button type="submit" class="btn btn-success">この条件で絞り込む</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/categoriesSelect.js') }}"></script>
@endsection
