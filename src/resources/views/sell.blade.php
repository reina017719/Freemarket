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
                    <input type="file" name="image" accept="image/*" style="display: none;" onchange="previewImage(this)">
                </label>
                <span id="fileName" style="margin-left: 10px;">選択されていません</span>
                <img id="preview">
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
                        <input type="checkbox" name="category_id[]" value="{{ $category->id }}" />{{ $category->category }}
                    </label>
                    @endforeach
                </div>
                @error('category_id')
                    <p class="form__error" style="color:red;">{{ $message }}</p>
                @enderror
            </div>
            <label class="form__label">商品の状態</label>
            <select class="select__condition" name="condition">
                <option value="" disabled selected>選択してください</option>
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
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

<script>
    function previewImage(input) {
        const file = input.files[0];
        const fileNameElement = document.getElementById('fileName');
        const previewElement = document.getElementById('preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewElement.src = e.target.result;
                previewElement.style.display = 'block';
            }
            reader.readAsDataURL(file);
            fileName.textContent = file.name;
        } else {
            preview.src = '';
            preview.style.display = 'none';
            fileName.textContent = '選択されていません';
        }
    }
</script>
@endsection