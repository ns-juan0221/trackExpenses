@extends('base')
@section('title', 'マネーログ')

@section('content')    
    <div class="routeDisplay w-100 border-bottom border-2">
        <p class="ms-2 p-1">
            <a href="{{ route('main') }}">ホーム</a>  ->  
            <a href="{{ route('histories') }}">履歴</a>  ->  
            <a href="#" onclick="event.preventDefault(); document.getElementById('detailForm').submit();">履歴詳細</a>

            <form id="detailForm" method="POST" action="{{ route('detail') }}" style="display: none;">
                @csrf
                <input type="hidden" name="id" value="{{ $type === 'income' ? $income->id : $outcomeGroup->id }}">
                <input type="hidden" name="type" value="{{ $type }}">
            </form>
        </p>
    </div>
    <div class="container-fluid flex-gow-1">
        <div class="logDetailContainer mt-3">
            @if ($type === 'income')
                <table class="text-center m-3">
                    <thead class="logGroupTitle border border-3">
                        <tr>
                            <th class="col-2">日付</th>
                            <th class="col-2">種類</th>
                            <th class="col-2">カテゴリ</th>
                            <th class="col-2">金額</th>
                            <th class="col-1">編集</th>
                            <th class="col-1">削除</th>
                        </tr>
                    </thead>
                    <tbody class="logGroupArticle">
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($income->date)->format('Y/m/d') }}</td>
                            <td>収入</td>
                            <td>{{ $income->category_name }}</td>
                            <td>{{ number_format($income->amount, 0, ',', ',') }}円</td>
                            <td>
                                <a href="{{ route('edit', ['id' => $income->id, 'type' => $type]) }}">
                                    <img src="{{ asset('images/editBtn2.png') }}" alt="" width="30">
                                </a>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('delete') }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $income->id }}">
                                        <input type="hidden" name="type" value="{{ $type }}">
                                        <button type="submit" class="btn deleteBtn px-3 mx-4">
                                            <img src="{{ asset('images/deleteBtn2.png') }}" width="30">
                                        </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="memo m-3">
                        <div class="memoTitle col-10">
                            メモ
                        </div>
                        {{ $income->memo }}
                </div>
            @else
                <table class="text-center m-3">
                    <thead class="logGroupTitle border border-3">
                        <tr>
                            <th class="col-2">日付</th>
                            <th class="col-2">種類</th>
                            <th class="col-2">ショップ名</th>
                            <th class="col-2">合計金額</th>
                            <th class="col-1">編集</th>
                            <th class="col-1">削除</th>
                        </tr>
                    </thead>
                    <tbody class="logGroupArticle">
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($outcomeGroup->date)->format('Y/m/d') }}</td>
                            <td>支出</td>
                            <td>{{ $outcomeGroup->shop }}</td>
                            <td>{{ number_format($outcomeGroup->totalPrice, 0, ',', ',') }}円</td>
                            <td>
                                <a href="{{ route('edit', ['id' => $outcomeGroup->id, 'type' => $type]) }}">
                                    <img src="{{ asset('images/editBtn2.png') }}" alt="" width="30">
                                </a>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('delete') }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $outcomeGroup->id }}">
                                        <input type="hidden" name="type" value="{{ $type }}">
                                        <button type="submit" class="btn deleteBtn px-3 mx-4">
                                            <img src="{{ asset('images/deleteBtn2.png') }}" width="30">
                                        </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end m-3">
                    <table class="col-10">
                        <thead class="logItemTitle border border-3">
                            <tr>
                                <th class="col-1">品目</th>
                                <th class="col-1">メインカテゴリ</th>
                                <th class="col-1">サブカテゴリ</th>
                                <th class="col-1">金額</th>
                                <th class="col-1">個数</th>
                                <th class="col-1">合計金額</th>
                            </tr>
                        </thead>
                        <tbody class="logItemArticle">
                            @foreach($outcomeItems as $item)
                                <tr>
                                    <td class="col-1 p-2"><span class="">{{ $item->item }}</span></td>
                                    <td class="col-1 p-2"><span class="">{{ $item->m_category_name }}</span></td>
                                    <td class="col-1 p-2"><span class="">{{ $item->s_category_name }}</span></td>
                                    <td class="col-1 py-2 pe-2"><span class="">{{ number_format($item->price, 0, ',', ',') }}円</span></td>
                                    <td class="col-1 py-2 pe-2"><span class="">{{ $item->amount }}個</span></td>
                                    <td class="col-1 py-2 pe-2"><span class="">{{ number_format($item->totalPrice, 0, ',', ',') }}円</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="memo d-flex justify-content-end m-3">
                    <div class="col-10">
                        <div class="memoTitle col-10">
                            メモ
                        </div>
                        {{ $outcomeGroup->memo }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection