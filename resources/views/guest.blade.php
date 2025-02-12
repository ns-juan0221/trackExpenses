@extends('base')
@section('title', 'マネーログ')

@section('content')
    <div class="routeDisplay w-100 border-bottom border-2">
        <p class="ms-2 p-1">
            <a href="{{ route('guest') }}">ゲスト</a>
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
                <div class="historyTitle d-flex justify-content-center align-items-center flex-grow-1 mt-3">
                    <p class="historyTitleText fs-5">直近の入出金履歴</p>
                </div>
                <div class="historyList px-2 flex-grow-1 mt-1">
                    @foreach($items as $item)
                        <div class="listItem mb-2">
                            {{-- {{ url('/edit/' . $item->id) }} --}}
                            <a href="#" class="itemLink">
                                <div class="d-flex justify-content-between">
                                    <div class="listDate w-50 ps-2">
                                        {{ \Carbon\Carbon::parse($item->date)->format('Y/m/d') }}
                                    </div>
                                    <div class="listPrice w-50 pe-3">
                                        -{{ number_format($item->totalPrice) }}円
                                    </div>
                                </div>
                                <div class="listCategory ps-2">
                                    {{ $item->m_category_name }}　->　{{ $item->s_category_name }}
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/bar-graph.js')}}"></script>
@endsection
