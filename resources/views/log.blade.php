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
            <div class="searchBtn d-flex justify-content-end w-100 me-5 mt-3">
                <button class="btn btn-success toggleButton me-5" id="toggleSearchButton" type="button" data-bs-toggle="collapse" data-bs-target="#searchForm" aria-expanded="false" aria-controls="searchForm">
                    検索
                </button>
            </div>
            <div class="searchForm collapse mt-2" id="searchForm">
                <form action="{{ route('histories.post') }}" class="formContainer align-items-center d-flex flex-column" method="post">
                    @csrf
                        <table class="searchTable">
                            <tbody>
                                <tr>
                                    <td class="keywordLabelList col-2" rowspan="3">
                                        <div class="searchLabel">
                                            <p>キーワード</p>
                                        </div>
                                    </td>
                                    <td class="keywordLabel itemLabel col-2">
                                        <div class="searchLabel">
                                            <p>商品名</p>
                                        </div>
                                    </td>
                                    <td class="itemKeywordInput col-8">
                                        <div class="formUnit d-flex">
                                            <input type="text" name="item-keyword" id="item-keyword" class="form-control" placeholder="検索キーワードを入力" value="" autocomplete="off" autofocus="" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="keywordLabel shopLabel col-2">
                                        <div class="searchLabel">
                                            <p>お店</p>
                                        </div>
                                    </td>
                                    <td class="shopKeywordInput col-8">
                                        <div class="formUnit d-flex">
                                            <input type="text" name="shop-keyword" id="shop-keyword" class="form-control" placeholder="検索キーワードを入力" value="" autocomplete="off" autofocus="" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="keywordLabel memoLabel col-2">
                                        <div class="searchLabel">
                                            <p>メモ</p>
                                        </div>
                                    </td>
                                    <td class="memoKeywordInput col-8">
                                        <div class="formUnit d-flex">
                                            <input type="text" name="memo-keyword" id="memo-keyword" class="form-control" placeholder="検索キーワードを入力" value="" autocomplete="off" autofocus="" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="priceLabel col-4" colspan="2">
                                        <div class="searchLabel">
                                            <p>金額</p>
                                        </div>
                                    </td>
                                    <td class="priceInput col-8">
                                        <div class="formUnit d-flex flex-row align-items-center">
                                            <div class="form-price me-1">
                                                <input type="text" name="min_price" id="minPrice" class="form-control" autocomplete="off"/>
                                                <div class="yen">¥</div>
                                            </div>
                                            <span class="from-to">～</span>
                                            <div class="form-price me-1">
                                                <input type="text" name="max_price" id="maxPrice" class="form-control" autocomplete="off"/>
                                                <div class="yen">¥</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="dateLabel col-4" colspan="2">
                                        <div class="searchLabel">
                                            <p>日付</p>
                                        </div>
                                    </td>
                                    <td class="dateInput col-8">
                                        <div class="formUnit d-flex flex-row align-items-center">
                                            <div class="form-date me-1">
                                                <input type="text" name="min_date" id="minDate" class="form-control" autocomplete="off" />
                                            </div>
                                            <span class="from-to">～</span>
                                            <div class="form-date me-1">
                                                <input type="text" name="max_date" id="maxDate" class="form-control" autocomplete="off" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="categoryLabel col-4" colspan="2">
                                        <div class="searchLabel">
                                            <p>カテゴリ</p>
                                        </div>
                                    </td>
                                    <td class="categoryInput col-8">
                                        <div class="formUnit d-flex flex-column">

                                            <script>
                                                window.groupedOutcomeCategories = @json($groupedOutcomeCategories);
                                                window.incomeCategories = @json($incomeCategories);
                                            </script>

                                            <div class="categorySelectBtn w-100">
                                                <button type="button" class="btn btn-success" onclick="openModal()">カテゴリを選択</button>
                                                <button type="button" class="btn btn-light" onclick="clearSelection()">選択をクリア</button>
                                            </div>
                                            <div id="selected-categories" class="selected-categories-container"></div>
                                            <input type="hidden" name="selectedCategories" id="selectedCategoriesInput" />
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
                <table class="logTable text-center">
                    <thead class="logTitle border border-3">
                        <tr>
                            <th class="col-1">日付</th>
                            <th class="col-1">種類</th>
                            <th class="col-1">カテゴリー</th>
                            <th class="col-1">ショップ名</th>
                            <th class="col-1">金額</th>
                            <th class="col-2">メモ</th>
                            <th class="col-1">詳細</th>
                            <th class="col-1">削除</th>
                        </tr>
                    </thead>
                    <tbody class="logItem w-100 m-2">
                        @foreach($totalBalances as $totalBalance)
                            <tr class="itemData">
                                <td>{{ \Carbon\Carbon::parse($totalBalance->date)->format('Y/m/d') }}</td>
                                <td>{{ $totalBalance->type === 'income' ? '収入' : '支出' }}</td>
                                <td>{{ $totalBalance->name }}</td>
                                <td>{{ $totalBalance->shop }}</td>
                                <td class="{{ $totalBalance->type === 'income' ? 'text-income' : 'text-outcome' }}">
                                    @if($totalBalance->type === 'income')
                                        +{{ number_format($totalBalance->amount, 0, ',', ',') }}円
                                    @else
                                        -{{ number_format($totalBalance->amount, 0, ',', ',') }}円
                                    @endif
                                </td>
                                <td>{{ Str::limit($totalBalance->memo, 10, '...') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('detail') }}" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $totalBalance->id }}">
                                        <input type="hidden" name="type" value="{{ $totalBalance->type }}">
                                        <button type="submit" class="btn editBtn px-3 mx-4">
                                            <img src="{{ asset('img/detailBtn.png') }}" width="30">
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('delete') }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $totalBalance->id }}">
                                        <input type="hidden" name="type" value="{{ $totalBalance->type }}">
                                        <button type="submit" class="btn deleteBtn px-3 mx-4">
                                            <img src="{{ asset('img/deleteBtn.png') }}" width="30">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
@endsection