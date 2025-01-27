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
    <!-- Remodal (CDN) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remodal/1.1.1/remodal.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remodal/1.1.1/remodal-default-theme.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/commons.css') }}">
    @if (Request::is('login') || Request::is('register'))
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    @elseif (Request::is('histories'))
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('css/article.css') }}">
    @endif
    <title>@yield('title')</title>
</head>
<body  class="d-flex flex-column min-vh-100">
    <!-- jQuery (CDN) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- jQuery UI (最新版1.14.0) -->
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.min.js"></script>
    <!-- Remodal (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/remodal/1.1.1/remodal.min.js"></script>

    @if (Request::is('login') || Request::is('register') || Request::is('guest'))
    <header id="header" class="header d-flex w-100 align-items-center border-bottom border-2 py-2">
        <a href="{{ route('getHalfYearGroupsAndLeastItemsToRedirectMain') }}" class="header-logo">
            <img src="{{ asset('images/header_icon.png') }}" alt="マネーログ" height="50" width="150">
        </a>
        <nav id="nav">
            <ul class="nav-btn">
                <li>
                    <a href="{{ route('register') }}" class="btn btn-success text-center">新規登録</a>
                </li>
                <li>
                    <a href="{{ route('login')}}" class="btn btn-light text-center">ログイン</a>
                </li>
            </ul>
        </nav>
    </header>
    @else
    <header id="header" class="header d-flex w-100 align-items-center border-bottom border-2 py-2">
        {{--  　　　　　　　　　追加機能　　　　　　　　　　 --}}
        {{-- 認証されていない箇所ではhrefをなくすか、mainに飛ばないようにする --}}
        <a href="{{ route('getHalfYearGroupsAndLeastItemsToRedirectMain') }}" class="header-logo">
            <img src="{{ asset('images/header_icon.png') }}" alt="マネーログ" height="50" width="150">
        </a>
        <nav id="nav">
            <ul class="nav-btn">
                <li>
                    <a href="{{ route('getCategoriesToInsert') }}" class="btn btn-success text-center">入力</a>
                </li>
                <li>
                    <a href="{{ route('new', ['type' => 'month']) }}" class="btn btn-light text-center">入出金履歴</a>
                </li>
                <li>
                    <a href="{{ route('setting') }}" class="btn btn-success text-center">設定</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="btn btn-light text-center">ログアウト</a>
                </li>
            </ul>
        </nav>
    </header>
    @endif

    <main class="flex-grow-1">
        @yield('content')

    </main>
    <footer class="text-center p-2">
        <div class="container d-flex justify-content-center align-items-center">
            <p class="me-3 mb-0">Follow us on</p>
            <div class="social-links">
                <a href="https://line.me/your_line_account" class="me-3" target="_blank">
                    <i class="fab fa-line fa-2x"></i>
                    <a href="https://www.instagram.com/your_instagram_account" class="me-3" target="_blank">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                    <a href="https://twitter.com/your_twitter_account" class="" target="_blank">
                        <i class="fab fa-twitter fa-2x"></i>
                    </a>
                </a>
            </div>
        </div>
    </footer>
    <!-- 日本語化ファイル (最新バージョンの適合するファイルを使用) -->
    <script src="{{ asset('js/datepicker-ja.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
