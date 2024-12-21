@extends('base')
@section('title', 'マネーログ')

@section('content')
    <div class="container-fluid">
        <div class="col-9">
            <div class="routeDisplay">
                <p class="ms-2 p-1"><a href="{{ route('getHalfYearGroupsAndLeastItems') }}">ホーム</a></p>
            </div>
            <div class="yearGraph d-flex flex-column">
                <div class="graphTitle d-flex justify-content-center align-items-center">
                    <p class="fs-3">半年間の支出遷移</p>
                </div>

                <script>
                    // BladeからデータをJavaScriptのグローバル変数に渡す
                    window.labels = @json($labels);
                    window.lastYearValues = @json($lastYearValues);
                    window.currentYearValues = @json($currentYearValues);
                </script>

                <div class="graphMain mt-3">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="history mt-4 ps-3 d-flex flex-column">
                @if (!empty($items))
                <div class="historyTitle d-flex justify-content-center align-items-center flex-grow-1">
                    <p class="historyTitleText">直近の入出金履歴</p>
                </div>
                <div class="historyList pe-2 flex-grow-1 overflow-auto mt-1">
                @foreach($items as $item)
                    <div class="listItem mb-2">
                        {{-- {{ url('/edit/' . $item->id) }} --}}
                        <a href="#" class="itemLink">
                            <div class="d-flex justify-content-between">
                                <div class="list-date w-50 ps-2">
                                    {{ \Carbon\Carbon::parse($item->date)->format('Y/m/d') }}
                                </div>
                                <div class="list-price w-50 pe-3">
                                    -{{ number_format($item->totalPrice) }}円
                                </div>
                            </div>
                            <div class="list-category ps-2">
                                {{ $item->m_category_name }}　->　{{ $item->s_category_name }}
                            </div>
                        </a>
                    </div>
                @endforeach
                </div>
                @else
                <div class="historyTitle-noData">
                    <p class="historyTitleText">直近の入出金履歴</p>
                </div>
                <div class="historyList-noData d-flex justify-content-center pe-2 flex-grow-1 mt-1">
                    <p class="p-3 text-noData">履歴はありません</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/bar-chart.js')}}"></script>
@endsection
