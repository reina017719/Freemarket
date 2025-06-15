@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="content-header">
    <ul>
        <button class="header__button">
            <li class="header__recommendation">おすすめ</li>
        </button>
        <button class="header__button">
            <li class="header__favorites">マイリスト</li>
        </button>
    </ul>
</div>

<main>
<div class="main-content">
    <div class="main-content__inner">
        @if (isset($items) && $items->isEmpty())
            <p>該当する商品は見つかりませんでした。</p>
        @else
        @foreach($items as $item)
        <div class="item">
            <a href="/item/{{ $item->id }}">
                <img class="item__image" src="{{ asset($item->image) }}" alt="商品画像">
            </a>
            <div class="item__detail">
                <label class="item__detail-label">{{ $item->name }}</label>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
</main>
@endsection