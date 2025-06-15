@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-image">
            @if($profile && $profile->image)
                <img class="profile-image__img" src="{{ asset('storage/' . $profile->image) }}" alt="">
            @endif
        </div>
        <h2 class="username">{{ $profile->name ?? Auth::user()->name }}</h2>
        <a href="/mypage/profile" class="edit-button">プロフィールを編集</a>
    </div>
    <div class="tabs">
        <span class="tab active">出品した商品</span>
        <span class="tab">購入した商品</span>
    </div>
    <div class="products-grid">
        <div class="product-card">
            <div class="product-image"></div>
            <p class="product-name"></p>
        </div>
    </div>
</div>
@endsection