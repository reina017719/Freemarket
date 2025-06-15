@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell-form__content">
    <div class="sell-form__heading">
        <h2>商品の出品</h2>
    </div>
    <form class="form" action="/sell" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form__group">
            <label class="form__label-image">商品画像</label>
            <div class="sell-image">
                <label class="image-button">画像を選択する
                <input type="file" name="image" accept="image/*" style="display: none;" onchange="document.getElementById('fileName').textContent = this.files[0]?.name || '選択されていません';" value="{{ old('image') }}">
                </label>
                <span id="fileName" style="margin-left: 10px;">選択されていません</span>
            </div>
            @error('image')
                <p class="form__error" style="color:red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__group">
            <div class="label__inner">
                <label class="form__label-category">商品の詳細</label>
            </div>
            <div class="category">
                <p class="form__label">カテゴリー</p>
                <div class="category-list">
                    @foreach($categories as $category)
                    <label class="category-item">
                        <input type="radio" name="category_id" value="{{ $category->id }}" />{{ $category->category }}
                    </label>
                    @endforeach
                </div>
                @error('category')
                    <p class="form__error" style="color:red;">{{ $message }}</p>
                @enderror
            </div>
            <label class="form__label">商品の状態</label>
            <select class="select__condition" name="condition_id">
                <option value="" disabled selected>選択してください</option>
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->condition}}</option>
                @endforeach
            </select>
            @error('condition')
                <p class="form__error" style="color:red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__group">
            <div class="label__inner">
                <label class="form__label-category">商品名と説明</label>
            </div>
            <label class="form__label">商品名</label>
            <input class="item__text" type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <p class="form__error" style="color:red;">{{ $message }}</p>
            @enderror
            <label class="form__label">ブランド名</label>
            <input class="item__text" type="text" name="brand" value="{{ old('brand') }}">
            <label class="form__label">商品の説明</label>
            <textarea name="description">{{ old('description') }}</textarea>
            @error('description')
                <p class="form__error" style="color:red;">{{ $message }}</p>
            @enderror
            <label class="form__label">販売価格</label>
            <div class="price-input-wrapper">
                <span class="yen-symbol">¥</span>
                <input class="item__text-price" type="text" name="price" value="{{ old('price') }}">
            </div>
            @error('price')
                <p class="form__error" style="color:red;">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">出品する</button>
        </div>
    </form>
</div>
@endsection