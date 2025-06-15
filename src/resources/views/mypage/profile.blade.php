@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-form__content">
    <div class="profile-form__heading">
        <h2>プロフィール設定</h2>
    </div>
    <form class="form" action="/profile" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form__group">
            <div class="profile-image">
                <img class="profile-image__item" id="imagePreview" src="" alt="">
                <label class="upload-button">画像を選択する
                <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;" value="{{ old('image') }}">
                </label>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <label class="form__label">ユーザー名</label>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}">
                </div>
                @error('name')
                    <p class="form__error" style="color:red;">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <label class="form__label">郵便番号</label>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input type="text" name="postal_code" value="{{ old('postal_code', optional(Auth::user()->profile)->postal_code) }}">
                </div>
                @error('postal_code')
                    <p class="form__error" style="color:red;">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <label class="form__label">住所</label>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input type="text" name="address" value="{{ old('address', optional(Auth::user()->profile)->address) }}">
                </div>
                @error('address')
                    <p class="form__error" style="color:red;">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <label class="form__label">建物名</label>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input type="text" name="building" value="{{ old('building', optional(Auth::user()->profile)->building) }}">
                </div>
                @error('building')
                <p class="form__error" style="color:red;">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection