@extends('base')
@section('title', 'Login Page:マネーログ')

@section('content')
    <div class="loginBox text-center">
        @if($errors->has('login_error'))
    <div class="alert alert-danger">
        {{ $errors->first('login_error') }}
    </div>
@endif

        <form action="/login" class="form-container border p-2" method="post">
            @csrf
            <img src="{{ asset('images/icon.png') }}" alt="logo" class="logo" height="100" width="100">
            <h1 class="h3 mb-3"></h1>
            <div class="form-group d-flex flex-row align-items-center">
                <label for="inputEmail" class="form-label visually-hidden">Email address</label>
                <input name="email" type="email" id="inputEmail" class="form-control" placeholder="メールアドレス" required autofocus>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group d-flex flex-row align-items-center mt-2">
                <label for="inputPassword" class="form-label visually-hidden">Password</label>
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="パスワード" required autofocus autocomplete="current-password">
                <div class="invalid-feedback"></div>
            </div>
            <!-- パスワード表示用のチェックボックス -->
            <div class="form-group d-flex justify-content-end mt-2">
                <label class="custom-label">
                    <input type="checkbox" id="showPassword" onclick="togglePassword()">
                    <span>パスワードを表示</span>
                </label>
            </div>
            <button class="btn btn-lg btn-success w-100 mb-2 mt-3" type="submit">Login</button>
            {{-- 　　　　　　　　　　　　　　追加機能　　　　　　　　　　　　　　　　 --}}
            {{-- $_SESSIONで解決できる？ --}}
            {{-- <div class="checkbox p-2">
                <label>
                    <input type="checkbox" name="auto-login" value="remember-me"> 次回から自動でログイン
                </label>
            </div> --}}
        </form>
        <div class="additional-links">
            <a class="m-2" href="{{ route('reset-password') }}">パスワードを忘れた方</a>
            <a class="m-2" href="{{ route('regist') }}">新規作成</a>
            {{-- <a href="#">サインインできませんか？ここをクリック</a> --}}
        </div>
    </div>
@endsection
