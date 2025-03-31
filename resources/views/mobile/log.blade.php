@extends('base')
@section('title', 'マネーログ')

@section('content')
    @if (session('success') || session('error'))
    <script>
        window.onload = function() {
            @if (session('success'))
                alert("{{ session('success') }}");
            @endif

            @if (session('error'))
                alert("{{ session('error') }}");
            @endif
        };
    </script>
    @endif

    <div class="routeDisplay w-100 border-bottom border-2">
        <p class="ms-2 p-1">
            <a href="{{ route('main') }}">ホーム</a>  ->  <a href="{{ route('histories') }}">履歴</a>
        </p>
    </div>
    <div class="logContainer container-fluid flex-gow-1">
        <div class="searchBox d-flex flex-column justify-content-center align-items-center w-100">
            <div class="searchBtn d-flex justify-content-end w-100 me-1 mt-3">
                <button class="btn btn-success toggleButton me-1" id="toggleSearchButton" type="button" data-bs-toggle="collapse" data-bs-target="#searchForm" aria-expanded="false" aria-controls="searchForm">
                    検索
                </button>
            </div>
            <div class="searchForm collapse mt-2" id="searchForm">
                <form action="{{ route('histories.post') }}" class="formContainer align-items-center d-flex flex-column" method="POST">
                    @csrf
                        <table class="searchTable">
                            <tbody>
                                <tr>
                                    <td class="keywordLabel itemLabel col-3">
                                        <div class="searchLabel">
                                            <p>商品名</p>
                                        </div>
                                    </td>
                                    <td class="itemKeywordInput col-9">
                                        <div class="formUnit d-flex">
                                            <input type="text" name="item-keyword" id="item-keyword" class="form-control" placeholder="検索キーワードを入力" value="" autocomplete="off" autofocus="" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="keywordLabel shopLabel col-3">
                                        <div class="searchLabel">
                                            <p>お店</p>
                                        </div>
                                    </td>
                                    <td class="shopKeywordInput col-9">
                                        <div class="formUnit d-flex">
                                            <input type="text" name="shop-keyword" id="shop-keyword" class="form-control" placeholder="検索キーワードを入力" value="" autocomplete="off" autofocus="" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="keywordLabel memoLabel col-3">
                                        <div class="searchLabel">
                                            <p>メモ</p>
                                        </div>
                                    </td>
                                    <td class="memoKeywordInput col-9">
                                        <div class="formUnit d-flex">
                                            <input type="text" name="memo-keyword" id="memo-keyword" class="form-control" placeholder="検索キーワードを入力" value="" autocomplete="off" autofocus="" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="priceLabel col-3">
                                        <div class="searchLabel">
                                            <p>金額</p>
                                        </div>
                                    </td>
                                    <td class="priceInput col-9">
                                        <div class="formUnit d-flex flex-row align-items-center">
                                            <div class="form-price">
                                                <input type="text" name="min_price" id="minPrice" class="form-control" autocomplete="off"/>
                                                <div class="yen">¥</div>
                                            </div>
                                            <span class="from-to">～</span>
                                            <div class="form-price">
                                                <input type="text" name="max_price" id="maxPrice" class="form-control" autocomplete="off"/>
                                                <div class="yen">¥</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="dateLabel col-3">
                                        <div class="searchLabel">
                                            <p>日付</p>
                                        </div>
                                    </td>
                                    <td class="dateInput col-9">
                                        <div class="formUnit d-flex flex-row align-items-center">
                                            <div class="form-date">
                                                <input type="text" name="min_date" id="minDate" class="form-control" autocomplete="off" />
                                            </div>
                                            <span class="from-to">～</span>
                                            <div class="form-date">
                                                <input type="text" name="max_date" id="maxDate" class="form-control" autocomplete="off" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <div class="formBtnGroup mt-2">
                        <button type="button" class="btn btn-light" id="resetBtn">指定した条件をクリア</button>
                        <button type="submit" class="btn btn-success">この条件で絞り込む</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="logBox mt-2 p-3">
            @if ($totalBalances->isEmpty())
                <p class="text-center mt-3">該当するデータがありません。</p>
            @else
                <div class="logTitle border-bottom border-2 mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="logTitleDate w-50 ms-3">
                            日付
                        </div>
                        <div class="logTitlePrice w-50 ms-2">
                            金額
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="logTitleType w-50 ms-3">
                            種類(カテゴリ名)
                        </div>
                        <div class="logTitleShop w-50 ms-2">
                            ショップ名
                        </div>
                    </div>
                </div>
                <div class="logItemList">
                    @foreach($totalBalances as $totalBalance)
                        <div class="logItem border-bottom border-2 mb-2">
                            <a href="#" class="itemLink" onclick="event.preventDefault(); document.getElementById('detailForm-{{ $totalBalance->type }}-{{ $totalBalance->id }}').submit();">
                                <form method="POST" id="detailForm-{{ $totalBalance->type }}-{{ $totalBalance->id }}" action="{{ route('detail') }}" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $totalBalance->id }}">
                                    <input type="hidden" name="type" value="{{ $totalBalance->type }}">
                                </form>
                                <div class="d-flex justify-content-between">
                                    <div class="logDate w-50 ms-3">
                                        {{ \Carbon\Carbon::parse($totalBalance->date)->format('Y/m/d') }}
                                    </div>
                                    <div class="logPrice w-50 ms-2 {{ $totalBalance->type === 'income' ? 'text-income' : 'text-outcome' }}">
                                        @if($totalBalance->type === 'income')
                                            +{{ number_format($totalBalance->amount, 0, ',', ',') }}円
                                        @else
                                            -{{ number_format($totalBalance->amount, 0, ',', ',') }}円
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="logType w-50 ms-3">
                                        {{ $totalBalance->type === 'income' ? '収入' : '支出' }}({{ $totalBalance->name }})
                                    </div>
                                    <div class="logShop w-50 ms-2">
                                        {{ $totalBalance->shop }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @if ($totalBalances->hasPages())
            <div class="paginationArea d-flex justify-content-center align-items-center my-3">
                {{-- 前のページがある場合のみ表示 --}}
                @if (!$totalBalances->onFirstPage())
                    <a href="{{ $totalBalances->previousPageUrl() }}" class="page-link">
                        &lt; {{ $totalBalances->currentPage() - 1 }}
                    </a>
                @endif

                {{-- 現在のページ --}}
                <span class="current-page mx-3">{{ $totalBalances->currentPage() }}</span>

                {{-- 次のページがある場合のみ表示 --}}
                @if ($totalBalances->hasMorePages())
                    <a href="{{ $totalBalances->nextPageUrl() }}" class="page-link">
                        {{ $totalBalances->currentPage() + 1 }} &gt;
                    </a>
                @endif
            </div>
        @endif
    </div>
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
    <script src="{{ asset('js/categoriesSelect.js') }}"></script>
    <script src="{{ asset('js/searchForm.js') }}"></script>
@endsection