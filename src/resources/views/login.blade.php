@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-form__content">
    <div class="login-form__heading">
        <h2>ログイン</h2>
    </div>
    <form class="form" action="/login" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <label class="form__label">メールアドレス</label>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input type="email" name="email" value="{{ old('email') }}" />
                </div>
                <div class="form__error">
                    <!--バリデーション機能を実装したら記述します。-->
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <label class="form__label">パスワード</label>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input type="password" name="password">
                </div>
                <div class="form__error">
                    <!--バリデーション機能を実装したら記述します。-->
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">ログインする</button>
            <div class="register__button">
                <a class="register__button-submit" href="/register">会員登録はこちら</a>
            </div>
        </div>
    </form>
</div>
@endsection