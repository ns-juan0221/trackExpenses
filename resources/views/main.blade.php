@extends('base')
@section('title', 'マネーログ')

@section('content')
    <div class="container-fluid">
        <div class="year-gragh d-flex flex-column">
            <div class="gragh-title mt-3 d-flex justify-content-center align-items-center">
                <p class="fs-3">半年間の支出遷移</p>
            </div>

            <script>
                // BladeからデータをJavaScriptのグローバル変数に渡す
                window.labels = @json($labels);
                window.lastYearValues = @json($lastYearValues);
                window.currentYearValues = @json($currentYearValues);
            </script>

            <div class="gragh-main mt-3">
                <canvas id="myChart" width="600" height="300"></canvas>
            </div>
        </div>
        <div class="history mt-4 ps-3 d-flex flex-column">
            <div class="history-title d-flex justify-content-center align-items-center flex-grow-1">
                <p>直近の履歴</p>
            </div>
            <div class="history-list pe-2 flex-grow-1 overflow-auto mt-3">
                @foreach($items as $item)
                <div class="list-item mb-2">
                    {{-- {{ url('/edit/' . $item->id) }} --}}
                    <a href="#" class="item-link">
                        <div class="d-flex justify-content-between">
                            <div class="list-date w-50 ps-2">
                                {{ \Carbon\Carbon::parse($item->date)->format('Y/m/d') }}
                            </div>
                            <div class="list-price w-50 pe-3">
                                -{{ number_format($item->totalPrice) }}円
                            </div>
                        </div>
                        <div class="list-category ps-2">
                            {{ $item->m_category_name }} -> {{ $item->s_category_name }}
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/bar-chart.js')}}"></script>
@endsection
