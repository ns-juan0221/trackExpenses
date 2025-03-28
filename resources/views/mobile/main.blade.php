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

            <div class="donutChart d-flex flex-column col-8 mt-4 w-100">
                <div class="chartTitle d-flex justify-content-center align-items-center mt-3">
                    <p class="chartTitleText fs-3">1ヶ月の収支バランス</p>
                </div>
                
                <script>
                    // BladeからデータをJavaScriptのグローバル変数に渡す
                    window.isPrevious = @json($isPrevious);
                    window.outcomes = @json($outcomes);
                    window.incomes = @json($incomes);
                </script>

                <div class="chartMain mt-3 mb-4 d-flex justify-content-center">
                    <canvas id="balanceChart"></canvas>
                </div>
                @if ($isPrevious)
                        <div class="noteOnChart mt-2">
                            <p>先月の収入分で計算しています</p>
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/donut-chart.js')}}"></script>
@endsection
