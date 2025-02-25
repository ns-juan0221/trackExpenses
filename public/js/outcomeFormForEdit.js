const inputShop = document.querySelector('#inputShop');
let shopErrorJs = document.querySelector('.shopValidationErrorJs');
let shopError = document.querySelector('.shopValidationError');

inputShop.addEventListener('input', () => {
    if(shopError && shopError.textContent !== ''){
        shopError.textContent = '';
    }

    if (inputShop.value.trim() === '') {
        inputShop.classList.remove('is-valid');
        inputShop.classList.add('is-invalid');
        shopErrorJs.textContent = '名前を入力してください';
    } else {
        inputShop.classList.remove('is-invalid');
        inputShop.classList.add('is-valid');
        shopErrorJs.textContent = '';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const formListBlock = document.querySelector('#formListBlock');

    document.querySelectorAll('.price, .amount').forEach(function (input) {
        input.addEventListener('input', function () {
            validateField(this);
            updateTotalPrice();
        });
    });

    document.querySelectorAll('.item, .category').forEach(function (input) {
        input.addEventListener('input', function () {
            validateField(this);
        });
    });

    formListBlock.addEventListener('input', (e) => {
        if (e.target.matches('.item, .price, .amount, .category')) {
            validateField(e.target);
            if (e.target.classList.contains('price') || e.target.classList.contains('amount')) {
                updateTotalPrice();
            }
        }
    });

    function validateField(field) {
        const fieldValue = field.value.trim();
        const errorContainer = field.closest('.formList').querySelector('.validationError');
        let errorMessage = '';

        if (field.classList.contains('item')) {
            if (!fieldValue) {
                errorMessage = '商品名を入力してください';
            }
        } else if (field.classList.contains('category')) {
            if (!fieldValue || fieldValue === 'default') {
                errorMessage = 'カテゴリを選択してください';
            }
        } else if (field.classList.contains('price')) {
            if (!fieldValue) {
                errorMessage = '金額を入力してください';
            } else if (isNaN(fieldValue) || fieldValue <= 0) {
                errorMessage = '金額は1以上の数字で入力してください';
            }
        } else if (field.classList.contains('amount')) {
            if (!fieldValue) {
                errorMessage = '個数を入力してください';
            } else if (isNaN(fieldValue) || fieldValue <= 0) {
                errorMessage = '個数は1以上の数字で入力してください';
            }
        }

        if (errorMessage) {
            field.classList.add('is-invalid');
            field.classList.remove('is-valid');
            if (errorContainer) {
                errorContainer.textContent = errorMessage;
            }
        } else {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
            if (errorContainer) {
                errorContainer.textContent = '';
            }
        }
        return !errorMessage;
    };

    function updateTotalPrice() {
        var total = 0;
        
        document.querySelectorAll('.formList').forEach(function(group) {
            var price = parseFloat(group.querySelector('.price').value) || 0;
            var amount = parseFloat(group.querySelector('.amount').value) || 1;
            total += price * amount;
        });
        document.getElementById('totalPrice').value = total;
    }
});