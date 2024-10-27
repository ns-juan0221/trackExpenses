@extends('base')
@section('title', 'マネーログ')

@section('content')
    <div class="container-fluid">
        <div class="year-gragh d-flex flex-column">
            <div class="gragh-title mt-3 d-flex justify-content-center align-items-center">
                <div class="previous_year">
                    <a href="#"><img src="{{ asset('images/left.png') }}" height="40" width="40"></a>
                </div>
                <div class="this_year ps-3 pe-3 ms-2 me-2">
                    <p class="fs-3">2024年</p>
                </div>
                <div class="next_year">
                    <a href="#"><img src="{{ asset('images/right.png') }}" height="40" width="40"></a>
                </div>
            </div>
            <div class="gragh-main mt-3 border border-dark border-4">
                <canvas id="myChart" width="600" height="300"></canvas>
            </div>
        </div>
        <div class="history mt-4 ps-3 d-flex flex-column">
            <div class="history-title d-flex justify-content-center align-items-center flex-grow-1">
                <p>直近の履歴</p>
            </div>
            <div class="history-list pe-2 flex-grow-1 overflow-auto mt-3">
                <div class="list-item mb-2">
                    <a href="編集用のURL" class="item-link">
                        <div class="d-flex justify-content-between">
                            <div class="list-date w-50 ps-2">
                                2024/10/16
                            </div>
                            <div class="list-price w-50 pe-3">
                                -123円
                            </div>
                        </div>
                        <div class="list-category ps-2">
                            食費　->　食料品
                        </div>
                    </a>
                </div>
                <div class="list-item mb-2">
                    <a href="編集用のURL" class="item-link">
                        <div class="d-flex justify-content-between">
                            <div class="list-date w-50 ps-2">
                                2024/10/15
                            </div>
                            <div class="list-price w-50 pe-3">
                                -1234円
                            </div>
                        </div>
                        <div class="list-category ps-2">
                            趣味・娯楽　->　本
                        </div>
                    </a>
                </div>
                <div class="list-item mb-2">
                    <a href="編集用のURL" class="item-link">
                        <div class="d-flex justify-content-between">
                            <div class="list-date w-50 ps-2">
                                2024/10/15
                            </div>
                            <div class="list-price w-50 pe-3">
                                -1234円
                            </div>
                        </div>
                        <div class="list-category ps-2">
                            趣味・娯楽　->　本
                        </div>
                    </a>
                </div>
                <div class="list-item mb-2">
                    <a href="編集用のURL" class="item-link">
                        <div class="d-flex justify-content-between">
                            <div class="list-date w-50 ps-2">
                                2024/10/15
                            </div>
                            <div class="list-price w-50 pe-3">
                                -1234円
                            </div>
                        </div>
                        <div class="list-category ps-2">
                            趣味・娯楽　->　本
                        </div>
                    </a>
                </div>
                <div class="list-item mb-2">
                    <a href="編集用のURL" class="item-link">
                        <div class="d-flex justify-content-between">
                            <div class="list-date w-50 ps-2">
                                2024/10/15
                            </div>
                            <div class="list-price w-50 pe-3">
                                -1234円
                            </div>
                        </div>
                        <div class="list-category ps-2">
                            趣味・娯楽　->　本
                        </div>
                    </a>
                </div>
                <div class="list-item mb-2">
                    <a href="編集用のURL" class="item-link">
                        <div class="d-flex justify-content-between">
                            <div class="list-date w-50 ps-2">
                                2024/10/15
                            </div>
                            <div class="list-price w-50 pe-3">
                                -1234円
                            </div>
                        </div>
                        <div class="list-category ps-2">
                            趣味・娯楽　->　本
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/bar-chart.js')}}"></script>
@endsection
