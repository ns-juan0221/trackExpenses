document.addEventListener('DOMContentLoaded', function() {
    const errorTexts = {
        categoryRequired: 'カテゴリを選択してください',
        amountRequired: '金額を入力してください',
        amountInvalid: '金額は1以上の半角整数で入力してください',
    };

    const form = document.querySelector(".needs-validation");
    const inputAmount = document.querySelector('#inputAmount');
    const amountErrorJs = document.querySelector('.amountValidationErrorJs');
    const amountError = document.querySelector('.amountValidationError');
    const inputCategory = document.querySelector('#inputCategory');
    const categoryErrorJs = document.querySelector('.categoryValidationErrorJS');

    inputAmount.addEventListener('input', () => {
        if(amountError && amountError.textContent !== ''){
            amountError.textContent = '';
        }

        const inputValue = inputAmount.value.trim();

        if (inputValue === '') {
            inputAmount.classList.remove('is-valid');
            inputAmount.classList.add('is-invalid');
            amountErrorJs.textContent = errorTexts.amountRequired;
        } else if (isNaN(inputValue) || inputValue <= 0 || !Number.isInteger(Number(fieldValue))) {
            inputAmount.classList.remove('is-valid');
            inputAmount.classList.add('is-invalid');
            amountErrorJs.textContent = errorTexts.amountInvalid;
        } else {
            inputAmount.classList.remove('is-invalid');
            inputAmount.classList.add('is-valid');
            amountErrorJs.textContent = '';
        }
    });

    inputCategory.addEventListener('change', () => {
        if (inputCategory.value === 'default' || inputCategory.value.trim() === '') {
            inputCategory.classList.remove('is-valid');
            inputCategory.classList.add('is-invalid');
            categoryErrorJs.textContent = errorTexts.categoryRequired;
        } else {
            inputCategory.classList.remove('is-invalid');
            inputCategory.classList.add('is-valid');
            categoryErrorJs.textContent = '';
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