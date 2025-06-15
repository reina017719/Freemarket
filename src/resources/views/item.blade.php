@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
<div class="item">
    <div class="item-content">
        <img class="item__image" src="{{ asset($item->image) }}" alt="商品画像">
    </div>
    <div class="item__info">
        <h2>{{ $item->name }}</h2>
        <p class="item-brand">{{ $item->brand }}</p>
        <div class="item-price">
            <label>&yen;
                <label class="price-width">{{ number_format($item->price) }}</label>
            </label>
            <label>(税込)</label>
        </div>
        <div class="icons">
            <form action="/items/{{ $item->id }}/favorite" method="POST" style="display: inline;">
            @csrf
                <button type="submit" style="background:none;border:none;cursor:pointer;">
                ⭐
                </button>
                <span>{{ $item->favorites->count() }}</span>
            </form>
            <span>💬 {{ $item->comments->count() }}</span>
        </div>
        <a href="/purchase/{{ $item->id }}">
            <button class="buy-button">購入手続きへ</button>
        </a>
        <h3>商品説明</h3>
        <div class="description">
            {!! nl2br(e($item->description)) !!}
        </div>
        <h3 class="item__info-title">商品の情報</h3>
        <label class="item__info-label">カテゴリー</label>
        <span class="item__info-category">{{ $item->category->category }}</span>
        <div class="item__condition">
            <label class="item__info-label">商品状態</label>
            <span class="item__info-condition">{{ $item->condition->condition }}</span>
        </div>
        <h3 class="comment__header">コメント({{ optional($item->comments)->count() }})</h3>
        @if(!empty($item->comments) && $item->comments instanceof \Illuminate\Support\Collection)
        @foreach($item->comments as $comment)
            <div class="comment">
                <div class="avatar">
                    <img class="avatar-img" src="{{ asset('storage/' . $comment->profile->image) }}" alt="">
                </div>
                    <div>
                        <p class="username">{{ $comment->profile->name}}</p>
                    </div>
                </div>
            <div class="comment-text">{{ $comment->comment}}</div>
        @endforeach
        @else
            <p>コメントはまだありません。</p>
        @endif
        <h4>商品へのコメント</h4>
        @auth
        <form action="/comment" method="post">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <textarea name="comment" required></textarea>
            <div class="comment__button">
                <button class="comment__button-submit" type="submit">コメントを送信する</button>
            </div>
        </form>
        @else
        <p>コメントを投稿するには <a href="/login">ログイン</a> してください。</p>
        @endauth
    </div>
</div>
@endsection