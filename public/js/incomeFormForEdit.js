const inputAmount = document.querySelector('#inputAmount');
let amountErrorJs = document.querySelector('.amountValidationErrorJs');
let amountError = document.querySelector('.amountValidationError');
const inputCategory = document.querySelector('#inputCategory');
let categoryErrorJs = document.querySelector('.amountValidationErrorJs');
let categoryError = document.querySelector('.amountValidationError');

inputAmount.addEventListener('input', () => {
    if(amountError && amountError.textContent !== ''){
        amountError.textContent = '';
    }
    const inputValue = inputAmount.value.trim();

    if (inputValue === '') {
        inputAmount.classList.remove('is-valid');
        inputAmount.classList.add('is-invalid');
        amountErrorJs.textContent = '金額を入力してください';
    } else if (isNaN(inputValue) || inputValue <= 0) {
        inputAmount.classList.remove('is-valid');
        inputAmount.classList.add('is-invalid');
        amountErrorJs = '正しい金額を入力してください';
    } else {
        inputAmount.classList.remove('is-invalid');
        inputAmount.classList.add('is-valid');
        amountErrorJs.textContent = '';
    }
});

inputCategory.addEventListener('input', () => {
    if(categoryError && categoryError.textContent !== ''){
        categoryError.textContent = '';
    }

    if (inputCategory.value.trim() === '') {
        inputCategory.classList.remove('is-valid');
        inputCategory.classList.add('is-invalid');
        categoryErrorJs.textContent = '名前を入力してください';
    } else {
        inputCategory.classList.remove('is-invalid');
        inputCategory.classList.add('is-valid');
        categoryErrorJs.textContent = '';
    }
});