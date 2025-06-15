@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="register-form__content">
    <div class="register-form__heading">
        <h2>住所の変更</h2>
    </div>
    <form class="form" action="/update" method="post">
        @csrf
        @method('PATCH')
        <input type="hidden" name="id" value="{{ $profile->id }}">
        <input type="hidden" name="item_id" value="{{ $item_id }}">
        <div class="form__group">
            <div class="form__group-title">
                <label class="form__label">郵便番号</label>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input type="text" name="postal_code" value="{{ old('postal_code', $profile->postal_code) }}">
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
                    <input type="text" name="address" value="{{ old('address', $profile->address) }}">
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
                    <input type="text" name="building" value="{{ old('building', $profile->building) }}">
                </div>
                @error('building')
                    <p class="form__error" style="color:red;">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">変更する</button>
        </div>
    </form>
</div>
@endsection