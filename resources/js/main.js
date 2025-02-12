//カレンダー
$(function(){
    $('#inputDate, #minDate, #maxDate').datepicker({
        showButtonPanel:true,
        dateFormat: 'yy/mm/dd',
        onSelect: function() {
            $(this).datepicker('hide');
            // カレンダーから選択された場合もバリデーションを実行
            validateDate();
        }
    });

    $('#inputDate').on('input change', function() {
        validateDate();
    });

    function validateDate() {
        const inputDate = $('#inputDate');
        const dateErrorJs = $('.dateValidationErrorJs');
        const dateError = $('.dateValidationError');
        const dateValue = inputDate.val().trim();
        const dateSimplePattern = /^[0-9\/]+$/; 
        const dateDetailPattern = /^\d{4}\/\d{2}\/\d{2}$/; 

        if (dateError && dateError.textContent !== '') {
            dateError.textContent = '';
        }

        if (dateValue === '') {
            // 日付が空の場合
            inputDate.removeClass('is-valid').addClass('is-invalid');
            dateError.textContent = '';
        } else if (!dateSimplePattern.test(dateValue)) {
            //数字以外の文字が入力された場合
            inputDate.removeClass('is-valid').addClass('is-invalid');
            dateErrorJs.text('数字と"/"以外の文字を入力しないでください');
        } else if (!dateDetailPattern.test(dateValue)) {
            // YYYY/MM/DD形式でない場合
            inputDate.removeClass('is-valid').addClass('is-invalid');
            dateErrorJs.text('YYYY/MM/DD形式で入力してください');
        } else {
            const [year, month, day] = dateValue.split('/').map(Number);
            const date = new Date(year, month - 1, day);
    
            // 入力された値が実際の日付として正しいか確認
            if (date.getFullYear() !== year || date.getMonth() + 1 !== month || date.getDate() !== day) {
                inputDate.removeClass('is-valid').addClass('is-invalid');
                dateErrorJs.text('有効な日付を入力してください');
            } else {
                // 正しい日付形式の場合
                inputDate.removeClass('is-invalid').addClass('is-valid');
                dateErrorJs.text('');
            }
        }
    }
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

// モーダルを開く
function openModal() {
    $('#categoryModal').modal('show');
}

$('#resetBtn').click(function() {
    $('.formContainer')[0].reset(); // フォーム全体をリセット
    clearSelection();
});

document.getElementById('toggleSearchButton').addEventListener('click', function () {
    const button = document.getElementById('toggleSearchButton');
    // 折りたたみの状態を取得
    const isCollapsed = document.getElementById('searchForm').classList.contains('show');

    // 折りたたみ状態に応じてクラスを切り替え
    if (!isCollapsed) {
        button.classList.add('moveToTopRight');
    } else {
        button.classList.remove('moveToTopRight');
    }
});