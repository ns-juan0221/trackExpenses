document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector(".needs-validation");
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
    const inputsToValidate = [inputName, inputKanaName, inputUsername, inputEmail];
    const formUnits = inputsToValidate.map(input => input.closest(".formUnit"));

    let inputs = form.querySelectorAll(".form-control");

    if (document.querySelector('.validationError')) {
        formUnits.forEach(formUnit => {
            formUnit.classList.add("was-validated");
        });
    }

    inputName.addEventListener('input', () => {
        const formUnit = inputName.closest(".formUnit");

        if (inputName.value !== inputName.getAttribute("value")) {
            inputName.setAttribute("value", inputName.value);
        }

        formUnit.classList.remove("was-validated");

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
        const formUnit = inputKanaName.closest(".formUnit");

        if (inputKanaName.value !== inputKanaName.getAttribute("value")) {
            inputKanaName.setAttribute("value", inputKanaName.value);
        }

        formUnit.classList.remove("was-validated");

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
        const formUnit = inputUsername.closest(".formUnit");

        if (inputUsername.value !== inputUsername.getAttribute("value")) {
            inputUsername.setAttribute("value", inputUsername.value);
        }

        formUnit.classList.remove("was-validated");

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
        const formUnit = inputEmail.closest(".formUnit");

        if (inputEmail.value !== inputEmail.getAttribute("value")) {
            inputEmail.setAttribute("value", inputEmail.value);
        }

        formUnit.classList.remove("was-validated");

        if (inputEmail.value !== inputEmail.getAttribute("value")) {
            inputEmail.setAttribute("value", inputEmail.value);
        }

        if(emailError && emailError.textContent !== ''){
            emailError.textContent = '';
        }

        if(inputEmail.value.trim() === ''){
            inputEmail.classList.add('is-invalid');
            inputEmail.classList.remove('is-valid');
            emailErrorJs.textContent = 'メールアドレスを入力してください';
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

        if(inputPassword.value.trim() === ''){
            inputPassword.classList.add('is-invalid');
            inputPassword.classList.remove('is-valid');
            passwordErrorJs.textContent = 'パスワードを入力してください';
        }else if (inputPassword.value.length < 8) {
            inputPassword.classList.add('is-invalid');
            inputPassword.classList.remove('is-valid');
            passwordErrorJs.textContent = 'パスワードは8文字以上で入力してください'; 
        } else if(!passwordPattern.test(inputPassword.value)) {
            passwordErrorJs.textContent = 'パスワードは英数字を1文字以上含んでください';
            inputPassword.classList.add('is-invalid');
            inputPassword.classList.remove('is-valid');
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

        if(inputPasswordConfirm.value.trim() === ''){
            inputPasswordConfirm.classList.add('is-invalid');
            inputPasswordConfirm.classList.remove('is-valid');
            passwordConfirmErrorJs.textContent = 'パスワードを入力してください';
        }else if (!(inputPasswordConfirm.value === inputPassword.value)) {
            inputPasswordConfirm.classList.add('is-invalid');
            inputPasswordConfirm.classList.remove('is-valid');
            passwordConfirmErrorJs.textContent = 'パスワードが一致しません'; 
        } else {
            inputPasswordConfirm.classList.remove('is-invalid');
            inputPasswordConfirm.classList.add('is-valid');
            passwordConfirmErrorJs.textContent = ''; 
        }
    });

    form.addEventListener("submit", function (event) {
        inputs = form.querySelectorAll(".form-control");
        let isValid = true;

        inputs.forEach(input => {
            if (input.classList.contains("is-invalid")) {
                isValid = false;
            }
        });

        if (!isValid) {
            event.preventDefault();
            event.stopPropagation();
            alert("入力内容にエラーがあります。修正してください。");
        }
    });
});