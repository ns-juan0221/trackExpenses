<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Font Awesome (CDN) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- jQuery UI CSS (CDN) -->
    <link href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/commons.css') }}">
    @if (Request::is('login') || Request::is('regist'))
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('css/article.css') }}">
    @endif
    <title>@yield('title')</title>
</head>
<body  class="d-flex flex-column min-vh-100">
    @if (Request::is('login') || Request::is('regist') || Request::is('guest'))
    <header id="header" class="border-bottom d-flex w-100 align-items-center">
        <a href="{{ route('main')}}" class="header-logo">
            <img src="{{ asset('images/header_icon.png') }}" alt="マネーログ" height="50" width="150">
        </a>
        <nav id="nav">
            <ul class="nav-btn">
                <li>
                    <a href="{{ route('regist') }}" class="btn btn-success text-center">新規登録</a>
                </li>
                <li>
                    <a href="{{ route('login')}}" class="btn btn-light text-center">ログイン</a>
                </li>
            </ul>
        </nav>
    </header>
    @else
    <header id="header" class="border-bottom d-flex w-100 align-items-center">
        {{--  　　　　　　　　　追加機能　　　　　　　　　　 --}}
        {{-- 認証されていない箇所ではhrefをなくすか、mainに飛ばないようにする --}}
        <a href="{{ route('main')}}" class="header-logo">
            <img src="{{ asset('images/header_icon.png') }}" alt="マネーログ" height="50" width="150">
        </a>
        <nav id="nav">
            <ul class="nav-btn">
                <li>
                    <a href="{{ route('new') }}" class="btn btn-light text-center">入力</a>
                </li>
                <li>
                    <a href="#" class="btn btn-success text-center">検索</a>
                </li>
                <li>
                    <a href="{{ route('new', ['type' => 'month']) }}" class="btn btn-light text-center">入出金履歴</a>
                </li>
                <li>
                    <a href="{{ route('setting') }}" class="btn btn-success text-center">設定</a>
                </li>
                <li>
                    <a href="#" class="btn btn-light text-center">ログアウト</a>
                </li>
            </ul>
        </nav>
    </header>
    @endif

    <main class="flex-grow-1">
        @yield('content')

    </main>
    <footer class="text-white text-center p-2">
        <div class="container d-flex justify-content-center align-items-center">
            <p class="me-3 mb-0">Follow us on</p>
            <div class="social-links">
                <a href="https://line.me/your_line_account" class="text-white me-3" target="_blank">
                    <i class="fab fa-line fa-2x"></i>
                    <a href="https://www.instagram.com/your_instagram_account" class="text-white me-3" target="_blank">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                    <a href="https://twitter.com/your_twitter_account" class="text-white" target="_blank">
                        <i class="fab fa-twitter fa-2x"></i>
                    </a>
                </a>
            </div>
        </div>
    </footer>
    <!-- jQuery (CDN) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- jQuery UI (最新版1.14.0) -->
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.min.js"></script>
    <!-- 日本語化ファイル (最新バージョンの適合するファイルを使用) -->
    <script src="{{ asset('js/datepicker-ja.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
