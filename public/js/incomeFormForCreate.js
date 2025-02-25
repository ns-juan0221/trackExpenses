document.addEventListener('DOMContentLoaded', function() {
    const inputAmount = document.querySelector('#inputAmount');
    const amountErrorJs = document.querySelector('.amountValidationErrorJs');
    const amountError = document.querySelector('.amountValidationError');
    const inputCategory = document.querySelector('#inputCategory');
    const categoryErrorJs = document.querySelector('.categoryValidationErrorJS');

    inputAmount.addEventListener('input', () => {
        const inputValue = inputAmount.value.trim();

        if(amountError && amountError.textContent !== ''){
            amountError.textContent = '';
        }

        if (inputValue === '') {
            inputAmount.classList.remove('is-valid');
            inputAmount.classList.add('is-invalid');
            amountErrorJs.textContent = '金額を入力してください';
        } else if (isNaN(inputValue) || inputValue <= 0) {
            inputAmount.classList.remove('is-valid');
            inputAmount.classList.add('is-invalid');
            amountErrorJs.textContent = '金額は1以上の半角数字で入力してください';
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
            categoryErrorJs.textContent = 'カテゴリを選択してください';
        } else {
            inputCategory.classList.remove('is-invalid');
            inputCategory.classList.add('is-valid');
            categoryErrorJs.textContent = '';
        }
    });
});