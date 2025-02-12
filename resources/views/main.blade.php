@extends('base')
@section('title', 'マネーログ')

@section('content')
    <div class="routeDisplay w-100 border-bottom border-2">
        <p class="ms-2 p-1">
            <a href="{{ route('main') }}">ホーム</a>
        </p>
    </div>
    <div class="container-fluid flex-grow-1">
        <div class="mainArticle d-flex justify-content-center">
            {{-- 今後、ドーナツチャートに変更できるようにする --}}
            <div class="BarGraph d-flex flex-column col-8 mt-4 me-1">
                <div class="graphTitle d-flex justify-content-center align-items-center mt-3">
                    <p class="graphTitleText fs-3">半年間の支出遷移</p>
                </div>
                
                <script>
                    // BladeからデータをJavaScriptのグローバル変数に渡す
                    window.labels = @json($labels);
                    window.lastYearValues = @json($lastYearValues);
                    window.currentYearValues = @json($currentYearValues);
                </script>

                <div class="graphMain mt-3 d-flex justify-content-center">
                    <canvas id="myChart" width="700" height="400"></canvas>
                </div>
            </div>
            <div class="history d-flex flex-column col-4 mt-4 ms-1">
                @if (!empty($totalBalances))
                    <div class="historyTitle d-flex justify-content-center align-items-center flex-grow-1 mt-3">
                        <p class="historyTitleText fs-5">直近の入出金履歴</p>
                    </div>
                    <div class="historyList px-2 flex-grow-1 mt-1">
                        @foreach($totalBalances as $item)
                            <div class="listItem mb-2">
                                <a href="#" class="itemLink" onclick="event.preventDefault(); document.getElementById('detailForm').submit();">
                                    <form id="detailForm" method="POST" action="{{ route('detail') }}" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <input type="hidden" name="type" value="outcome">
                                    </form>

                                    <div class="d-flex justify-content-between">
                                        <div class="listDate w-50 px-2">
                                            {{ \Carbon\Carbon::parse($item->date)->format('Y/m/d') }}
                                        </div>
                                        <div class="listPrice w-50 pe-3">
                                            @if ($item->type === 'income')
                                                +{{ number_format($item->amount) }}円
                                            @else
                                                -{{ number_format($item->amount) }}円
                                            @endif
                                        </div>
                                    </div>
                                    <div class="listCategory ps-2">
                                        @if ($item->type === 'income')
                                            {{ $item->m_category_name }}
                                        @else
                                            {{ $item->m_category_name }}　->　{{ $item->s_category_name }}
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="historyTitle-noData  d-flex justify-content-center align-items-center flex-grow-1 mt-3">
                        <p class="historyTitleText fs-5">直近の入出金履歴</p>
                    </div>
                    <div class="historyList-noData flex-grow-1 mt-3">
                        <div class="listItem mb-2">
                            <a href="#" class="itemLink">
                                <div class="d-flex justify-content-between">
                                    <div class="listDate w-100 ps-2">
                                        まだ履歴はありません
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="listItem mb-2">
                            <a href="#" class="itemLink">
                                <div class="d-flex justify-content-between">
                                    <div class="listDate w-100 ps-2">
                                        早速、登録してみよう
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="listItem mb-2">
                            <a href="#" class="itemLink">
                                <div class="d-flex justify-content-between">
                                    <div class="listDate w-100 ps-2">
                                        上の「入力」をクリック☝️
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/bar-graph.js')}}"></script>
@endsection
