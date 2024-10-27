//カレンダー
$(function(){
    $('#date').datepicker({
        showButtonPanel:true
    });
});

function togglePassword() {
    const passwordField = document.getElementById('inputPassword');
    const showPasswordCheckbox = document.getElementById('showPassword');

    // チェックボックスがチェックされたときに type を text に切り替える
    if (showPasswordCheckbox.checked) {
        passwordField.type = "text";
    } else {
        // チェックが外されたときは再び password に切り替える
        passwordField.type = "password";
    }
}
