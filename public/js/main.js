document.addEventListener('DOMContentLoaded', function () {
    $(function(){
        $('#inputDate, #minDate, #maxDate').datepicker({
            showButtonPanel:true,
            dateFormat: 'yy/mm/dd',
            onSelect: function() {
                $(this).datepicker('hide');
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
                inputDate.removeClass('is-valid').addClass('is-invalid');
                dateError.textContent = '';
            } else if (!dateSimplePattern.test(dateValue)) {
                inputDate.removeClass('is-valid').addClass('is-invalid');
                dateErrorJs.text('数字と"/"以外の文字を入力しないでください');
            } else if (!dateDetailPattern.test(dateValue)) {
                inputDate.removeClass('is-valid').addClass('is-invalid');
                dateErrorJs.text('YYYY/MM/DD形式で入力してください');
            } else {
                const [year, month, day] = dateValue.split('/').map(Number);
                const date = new Date(year, month - 1, day);

                if (date.getFullYear() !== year || date.getMonth() + 1 !== month || date.getDate() !== day) {
                    inputDate.removeClass('is-valid').addClass('is-invalid');
                    dateErrorJs.text('有効な日付を入力してください');
                } else {
                    inputDate.removeClass('is-invalid').addClass('is-valid');
                    dateErrorJs.text('');
                }
            }
        }
    });
});

$('#resetBtn').click(function() {
    $('.formContainer')[0].reset();
    clearSelection();
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

function openModal() {
    $('#categoryModal').modal('show');
}

$(document).ready(function() {
    $("#menuToggle").click(function() {
        $("#sideMenu").addClass("open");
        $("#overlay").fadeIn();
    });
});