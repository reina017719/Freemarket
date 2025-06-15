<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoachTech</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class href="/">
                <img class="header__logo" src="{{ asset('images/logo.svg') }}" alt="COACH TECH">
            </a>
            @php
                $currentRouteName = Route::currentRouteName();
            @endphp

            @if (!in_array($currentRouteName, ['login', 'register']))
            <div class="header__search">
                <form action="{{ route('items.search') }}" method="get">
                    <input class="header__search-form" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？">
                    <button type="submit" style="display:none;"></button>
                </form>
            </div>
            <div class="header__nav">
                @if (Auth::check())
                <form action="/logout" method="post">
                    @csrf
                    <button class="header__nav-logout" type="submit" type="submit">ログアウト</button>
                </form>
                @else
                    <a class="header__nav-item" href="/login">ログイン</a>
                @endif
                <a class="header__nav-item" href="/mypage">マイページ</a>
                <a class="header__nav-button" href="/sell">出品</a>
            </div>
            @endif
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>