@extends('base')
@section('title', 'マネーログ')

@section('content')
    <div class="container-fluid">
        <div class="col-9">
            <div class="routeDisplay">
                <p class="ms-2 p-1"><a href="{{ route('guest') }}">ゲスト</a></p>
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
                <div class="historyTitle d-flex justify-content-center align-items-center flex-grow-1">
                    <p>直近の入出金履歴</p>
                </div>
                <div class="historyList pe-2 flex-grow-1 overflow-auto mt-1">
                    <div class="listItem mb-2">
                        <a href="{{ route('guest') }}" class="itemLink">
                            <div class="d-flex justify-content-between">
                                <div class="listDate w-50 ps-2">
                                    2024/10/16
                                </div>
                                <div class="listPrice w-50 pe-3">
                                    -123円
                                </div>
                            </div>
                            <div class="listCategory ps-2">
                                食費　->　食料品
                            </div>
                        </a>
                    </div>
                    <div class="listItem mb-2">
                        <a href="{{ route('guest') }}" class="itemLink">
                            <div class="d-flex justify-content-between">
                                <div class="listDate w-50 ps-2">
                                    2024/10/15
                                </div>
                                <div class="listPrice w-50 pe-3">
                                    -1234円
                                </div>
                            </div>
                            <div class="listCategory ps-2">
                                趣味・娯楽　->　本
                            </div>
                        </a>
                    </div>
                    <div class="listItem mb-2">
                        <a href="{{ route('guest') }}" class="itemLink">
                            <div class="d-flex justify-content-between">
                                <div class="listDate w-50 ps-2">
                                    2024/10/15
                                </div>
                                <div class="listPrice w-50 pe-3">
                                    -1234円
                                </div>
                            </div>
                            <div class="listCategory ps-2">
                                趣味・娯楽　->　本
                            </div>
                        </a>
                    </div>
                    <div class="listItem mb-2">
                        <a href="{{ route('guest') }}" class="itemLink">
                            <div class="d-flex justify-content-between">
                                <div class="listDate w-50 ps-2">
                                    2024/10/15
                                </div>
                                <div class="listPrice w-50 pe-3">
                                    -1234円
                                </div>
                            </div>
                            <div class="listCategory ps-2">
                                趣味・娯楽　->　本
                            </div>
                        </a>
                    </div>
                    <div class="listItem mb-2">
                        <a href="{{ route('guest') }}" class="itemLink">
                            <div class="d-flex justify-content-between">
                                <div class="listDate w-50 ps-2">
                                    2024/10/15
                                </div>
                                <div class="listPrice w-50 pe-3">
                                    -1234円
                                </div>
                            </div>
                            <div class="listCategory ps-2">
                                趣味・娯楽　->　本
                            </div>
                        </a>
                    </div>
                    <div class="listItem mb-2">
                        <a href="{{ route('guest') }}" class="itemLink">
                            <div class="d-flex justify-content-between">
                                <div class="listDate w-50 ps-2">
                                    2024/10/15
                                </div>
                                <div class="listPrice w-50 pe-3">
                                    -1234円
                                </div>
                            </div>
                            <div class="listCategory ps-2">
                                趣味・娯楽　->　本
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/bar-chart.js')}}"></script>
@endsection
