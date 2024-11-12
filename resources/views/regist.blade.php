@extends('base')
@section('title', 'Regist Page:マネーログ')

@section('content')
    <div class="registBox text-center">
        <form action="/regist" class="form-container border p-2 align-items-center" method="post">
            @csrf
            <h1 class="h3 mb-3">新規登録</h1>
            <div class="form-group d-flex flex-row align-items-center mb-3">
                <label for="inputName" class="form-label">名前：</label>
                <input type="text" name="name" id="inputName" class="form-control" placeholder="ウェカピポ太郎" required="" autofocus="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group d-flex flex-row align-items-center mb-3">
                <label for="inputUsername" class="form-label">ユーザーネーム：</label>
                <input type="username" name="username" id="inputUsername" class="form-control" placeholder="ピポ" required="" autofocus="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group d-flex flex-row align-items-center mb-3">
                <label for="inputEmail" class="form-label">メールアドレス：</label>
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="sample@moneylog.com" required="" autofocus="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group d-flex flex-row align-items-center mb-3">
                <label for="inputPassword" class="form-label">パスワード：</label>
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="password" required="" autofocus="">
                <div class="invalid-feedback"></div>
            </div>
            <!-- パスワード表示用のチェックボックス -->
            <div class="form-group d-flex justify-content-end mb-3">
                <label class="custom-label">
                    <input type="checkbox" id="showPassword" onclick="togglePassword()">
                    <span>パスワードを表示</span>
                </label>
            </div>
            <div class="form-group d-flex flex-row align-items-center mb-3">
                <label for="inputPasswordConfirmation" class="form-label">パスワード確認：</label>
                <input type="password" name="password_confirmation" id="inputPasswordConfirmation" class="form-control" placeholder="******" required="">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-lg btn-success w-100 mb-2" type="submit">ユーザー登録</button>
        </form>
    </div>
@endsection
