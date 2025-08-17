@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="content-header">
    <ul>
        <li><button class="header__button" id="recommendation">おすすめ</button></li>
        @if(Auth::check())
        <li><button class="header__button" id="show-favorites">マイリスト</button></li>
        @endif
    </ul>
</div>

<main>
<div class="main-content">
    <div id="list-wrapper">
        <div class="main-content__inner" id="recommendation-list">
            @if(isset($items) && $items->isEmpty())
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

        @if(Auth::check())
        <div class="main-content__inner hidden" id="favorites-list">
            @if($favorites->isEmpty())
                <p>マイリストに商品はありません</p>
            @else
                @foreach($favorites as $item)
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
        @endif
    </div>
</div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const recBtn = document.getElementById('recommendation');
        const favBtn = document.getElementById('show-favorites');
        const recList = document.getElementById('recommendation-list');
        const favList = document.getElementById('favorites-list');

        if(recBtn) {
            recBtn.addEventListener('click', function() {
                recList.classList.remove('hidden');
                if(favList) favList.classList.add('hidden');
            });
        }

    if(favBtn) {
        favBtn.addEventListener('click', function() {
            if(favList) favList.classList.remove('hidden');
            recList.classList.add('hidden');
        });
    }
});
</script>
@endsection
