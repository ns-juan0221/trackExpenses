@extends('base')
@section('title', 'マネーログ')

@section('content')    
    <div class="routeDisplay w-100 border-bottom border-2">
        <p class="ms-2 p-1">
            <a href="{{ route('main') }}">ホーム</a>  ->  
            <a href="{{ route('histories') }}">履歴</a>  ->  
            <a href="#" onclick="event.preventDefault(); document.getElementById('detailForm').submit();">履歴詳細</a>

            <form id="detailForm" action="{{ route('detail') }}" style="display: none;" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $type === 'income' ? $income->id : $outcomeGroup->id }}">
                <input type="hidden" name="type" value="{{ $type }}">
            </form>
        </p>
    </div>
    <div class="container-fluid flex-gow-1">
        <div class="logDetailContainer mt-3">
            @if ($type === 'income')
                <table class="text-center m-1">
                    <thead class="logGroupTitle border border-3">
                        <tr>
                            <th class="col-2">日付</th>
                            <th class="col-2">種類</th>
                            <th class="col-2">カテゴリ</th>
                            <th class="col-2">金額</th>
                        </tr>
                    </thead>
                    <tbody class="logGroupArticle">
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($income->date)->format('Y/m/d') }}</td>
                            <td>収入</td>
                            <td>{{ $income->category_name }}</td>
                            <td>{{ number_format($income->amount, 0, ',', ',') }}円</td>
                            
                        </tr>
                    </tbody>
                </table>
                <div class="memo m-3">
                        <div class="memoTitle col-10">
                            メモ
                        </div>
                        {{ $income->memo }}
                </div>
                <a href="{{ route('edit', ['id' => $income->id, 'type' => $type]) }}">
                    <img src="{{ asset('img/editBtn.png') }}" alt="" width="30">
                </a>
                <form method="POST" action="{{ route('delete') }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{ $income->id }}">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <button type="submit" class="btn deleteBtn px-3 mx-4">
                            <img src="{{ asset('img/deleteBtn.png') }}" width="30">
                        </button>
                </form>
            @else
                <div class="logGroup border-bottom border-2">
                    <div class="">
                        <div class="logDate fs-3 ms-1 mt-1 mb-2 border-bottom border-2">
                            {{ \Carbon\Carbon::parse($outcomeGroup->date)->format('Y/m/d') }}
                        </div>
                        <div class="logShop ms-2 fs-5">
                            お店：{{ $outcomeGroup->shop }}
                        </div>
                        <div class="logTotalPrice ms-2 fs-5">
                            合計：{{ number_format($outcomeGroup->totalPrice, 0, ',', ',') }}円
                        </div>
                    </div>
                </div>
                <div class="logItemDetailTitle mt-3 border-bottom border-2">
                    <div class="d-flex justify-content-between">
                        <div class="logDetailItem ms-3">
                            商品名
                        </div>
                        <div class="logDetailPrice ms-2">
                            金額
                        </div>
                        <div class="logDetailAmount ms-2">
                            個数
                        </div>
                    </div>
                </div>
                <div class="logItemDetailArticle mt-1">
                    @foreach($outcomeItems as $item)
                        <div class="d-flex justify-content-between">
                            <div class="logDetailItem ms-3">
                                {{ Str::limit($item->item, 18, '...') }}
                            </div>
                            <div class="logDetailPrice ms-2">
                                {{ Str::limit(number_format($item->price, 0, ',', ','), 18, '...') }}円
                            </div>
                            <div class="logDetailAmount ms-2">
                                {{ number_format($item->amount, 0, ',', ',') }}個
                            </div>
                        </div>
                        <div class="d-flex justify-content-between border-bottom border-2">
                            <div class="logDetailCategory ms-3">
                                {{ $item->m_category_name }}　->　 {{ $item->s_category_name }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="logGroup  mt-2">
                    <div class="memoTitle ms-3">
                        メモ
                    </div>
                    {{ $outcomeGroup->memo }}
                </div>
                <div class="btnGroup d-flex justify-content-center flex-row mx-1 my-3">
                    <a class="editBtn btn btn-success" href="{{ route('edit', ['id' => $outcomeGroup->id, 'type' => $type]) }}">
                        編集する
                    </a>
                    <div class="deleteBtn ms-1">
                        <form method="POST" action="{{ route('delete') }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $outcomeGroup->id }}">
                                <input type="hidden" name="type" value="{{ $type }}">
                                <button type="submit" class="btn btn-light w-100">
                                    削除する
                                </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection