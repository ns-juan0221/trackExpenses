document.addEventListener('DOMContentLoaded', () => {
    const inputName = document.querySelector('#inputName');
    const nameErrorJs = document.querySelector('.nameValidationErrorJs');
    const nameError = document.querySelector('.nameValidationError');
    const inputKanaName = document.querySelector('#inputKanaName');
    const kanaNameErrorJs = document.querySelector('.kanaNameValidationErrorJs');
    const kanaNameError = document.querySelector('.kanaNameValidationError');
    const inputUsername = document.querySelector('#inputUsername');
    const usernameErrorJs = document.querySelector('.usernameValidationErrorJs');
    const usernameError = document.querySelector('.usernameValidationError');
    const inputEmail = document.querySelector('#inputEmail');
    const emailErrorJs = document.querySelector('.emailValidationErrorJs');
    const emailError = document.querySelector('.emailValidationError');
    const inputPassword = document.querySelector('#inputPassword');
    const passwordErrorJs = document.querySelector('.passwordValidationErrorJs');
    const passwordError = document.querySelector('.passwordValidationError');
    const inputPasswordConfirm = document.querySelector('#inputPasswordConfirm');
    const passwordConfirmErrorJs = document.querySelector('.passwordConfirmValidationErrorJs');

    inputName.addEventListener('input', () => {
        if(nameError && nameError.textContent !== ''){
            nameError.textContent = '';
        }

        if (inputName.value.trim() === '') {
            inputName.classList.remove('is-valid');
            inputName.classList.add('is-invalid');
            nameErrorJs.textContent = '名前を入力してください';
        } else {
            inputName.classList.remove('is-invalid');
            inputName.classList.add('is-valid');
            nameErrorJs.textContent = '';
        }
    });

    inputKanaName.addEventListener('input', () => {
        if(kanaNameError && kanaNameError.textContent !== ''){
            kanaNameError.textContent = '';
        }

        if (inputKanaName.value.trim() === '') {
            inputKanaName.classList.remove('is-valid');
            inputKanaName.classList.add('is-invalid');
            kanaNameErrorJs.textContent = 'カナを入力してください';
        } else {
            inputKanaName.classList.remove('is-invalid');
            inputKanaName.classList.add('is-valid');
            kanaNameErrorJs.textContent = '';
        }
    });

    inputUsername.addEventListener('input', () => {
        if(usernameError && usernameError.textContent !== ''){
            usernameError.textContent = '';
        }

        if (inputUsername.value.trim() === '') {
            inputUsername.classList.remove('is-valid');
            inputUsername.classList.add('is-invalid');
            usernameErrorJs.textContent = 'ユーザーネームを入力してください';
        } else {
            inputUsername.classList.remove('is-invalid');
            inputUsername.classList.add('is-valid');
            usernameErrorJs.textContent = '';
        }
    });

    inputEmail.addEventListener('input', () => {
        const emailPattern = /^(?=.{1,64}@)(?=.{1,255}$)[a-zA-Z0-9]+([._+-][a-zA-Z0-9]+)*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if(emailError && emailError.textContent !== ''){
            emailError.textContent = '';
        }

        if(inputEmail.value.trim() === ''){
            inputEmail.classList.add('is-invalid');
            inputEmail.classList.remove('is-valid');
            emailErrorJs.textContent = 'このフィールドの入力は必須です';
        }else if (!emailPattern.test(inputEmail.value)) {
            inputEmail.classList.add('is-invalid');
            inputEmail.classList.remove('is-valid');
            emailErrorJs.textContent = '正しいメールアドレスを入力してください';
        }else {
            inputEmail.classList.remove('is-invalid');
            inputEmail.classList.add('is-valid');
            emailErrorJs.textContent = ''; 
        }
    });

    // リアルタイムで文字数をチェック
    inputPassword.addEventListener('input', () => {
        const passwordPattern = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

        if (inputPassword.value.length < 8) {
            inputPassword.classList.add('is-invalid');
            inputPassword.classList.remove('is-valid');
            passwordErrorJs.textContent = 'パスワードは8文字以上で入力してください'; 
        } else if(!passwordPattern.test(inputPassword.value)) {
            passwordErrorJs.textContent = 'パスワードは英数字を1文字以上含んでください';
        } else {
            inputPassword.classList.remove('is-invalid');
            inputPassword.classList.add('is-valid');
            passwordErrorJs.textContent = ''; 
        }
    });
    
    // リアルタイムで文字数をチェック
    inputPasswordConfirm.addEventListener('input', () => {
        if(passwordError && passwordError.textContent !== ''){
            passwordError.textContent = '';
        }

        if (!(inputPasswordConfirm.value === inputPassword.value)) {
            inputPasswordConfirm.classList.add('is-invalid');
            inputPasswordConfirm.classList.remove('is-valid');
            passwordConfirmErrorJs.textContent = 'パスワードが一致しません'; 
        } else {
            inputPasswordConfirm.classList.remove('is-invalid');
            inputPasswordConfirm.classList.add('is-valid');
            passwordConfirmErrorJs.textContent = ''; 
        }
    });

    if (document.querySelector('.validationError')) {
        const ErrorJsForm = document.querySelector('.needs-validation');
        if (ErrorJsForm) {
        ErrorJsForm.classList.add('was-validated');
        }
    }
});