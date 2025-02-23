@extends('base')
@section('title', 'Register Page:マネーログ')

@section('content')
    <div class="registerBox text-center">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('createUser') }}" class="formContainer needs-validation border p-2 align-items-center" method="POST">
            @csrf
            <h1 class="h3 mb-3">新規登録</h1>
            <div class="formGroupBlock">
                <div class="form-group d-flex flex-column">
                    <div class="formUnit d-flex flex-row align-items-center">
                        <label for="inputName" class="form-label">名前：</label>
                        <input type="text" name="name" id="inputName" class="form-control" placeholder="マネーログ太郎" value="{{ $errors->has('name') ? '' : old('name') }}" required autocomplete="off">
                    </div>
                    <div class="text-danger nameValidationErrorJs"></div>
                    @error('name')
                        <div class="validationError nameValidationError text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group d-flex flex-column">
                    <div class="formUnit d-flex flex-row align-items-center mt-2">
                        <label for="inputKanaName" class="form-label">カナ：</label>
                        <input type="text" name="name_kana" id="inputKanaName" class="form-control" placeholder="マネーログタロウ" value="{{ $errors->has('name_kana') ? '' : old('name_kana')  }}" required autocomplete="off">
                    </div>
                    <div class="text-danger kanaNameValidationErrorJs"></div>
                    @error('name_kana')
                        <div class="validationError kanaNameValidationError text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group d-flex flex-column">
                    <div class="formUnit d-flex flex-row align-items-center mt-2">
                        <label for="inputUsername" class="form-label">ユーザーネーム：</label>
                        <input type="text" name="username" id="inputUsername" class="form-control" placeholder="タロ" value="{{ $errors->has('username') ? '' : old('username') }}" required autocomplete="off">
                    </div>
                    <div class="text-danger usernameValidationErrorJs"></div>
                    @error('username')
                        <div class="validationError usernameValidationError text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group d-flex flex-column">
                    <div class="formUnit d-flex flex-row align-items-center mt-2">
                        <label for="inputEmail" class="form-label">メールアドレス：</label>
                        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="sample@moneylog.com" value="{{ $errors->has('email') ? '' : old('email') }}" required autocomplete="off">
                    </div>
                    <div class="text-danger emailValidationErrorJs"></div>
                    @error('email')
                        <div class="validationError emailValidationError text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group d-flex flex-column">
                    <div class="formUnit d-flex flex-row align-items-center mt-2">
                        <label for="inputPassword" class="form-label">パスワード：</label>
                        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="英数字8文字以上" required>
                    </div>
                    <div class="text-danger passwordValidationErrorJs"></div>
                    @error('password')
                        <div class="validationError passwordValidationError text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- パスワード表示用のチェックボックス -->
                <div class="formUnit d-flex justify-content-end">
                    <label class="custom-label">
                        <input type="checkbox" id="showPassword" onclick="togglePassword()">
                        <span>パスワードを表示</span>
                    </label>
                </div>
            </div>
            <div class="form-group d-flex flex-column">
                <div class="formUnit d-flex flex-row align-items-center mt-2">
                    <label for="inputPasswordConfirm" class="form-label">パスワード確認：</label>
                    <input type="password" name="password_confirmation" id="inputPasswordConfirm" class="form-control" placeholder="********" required>
                </div>
                <div class="text-danger passwordConfirmValidationErrorJs"></div>
            </div>
            <button class="btn btn-lg btn-success w-100 mt-3 mb-2" type="submit">ユーザー登録</button>
        </form>
    </div>
    <script src="{{ asset('js/registerForm.js') }}"></script>
@endsection
