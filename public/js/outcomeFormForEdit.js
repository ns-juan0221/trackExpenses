document.addEventListener('DOMContentLoaded', function() {
    const errorTexts = {
        shopNameRequired: '名前を入力してください',
        itemRequired: '商品名を入力してください',
        categoryRequired: 'カテゴリを選択してください',
        priceRequired: '金額を入力してください',
        priceInvalid: '金額は1以上の半角整数で入力してください',
        amountRequired: '個数を入力してください',
        amountInvalid: '個数は1以上の半角整数で入力してください',
    };

    const form = document.querySelector(".needs-validation");
    const formListBlock = document.querySelector('#formListBlock');
    const inputShop = document.querySelector('#inputShop');
    const shopErrorJs = document.querySelector('.shopValidationErrorJs');
    const shopError = document.querySelector('.shopValidationError');

    let errorMessages = {};

    document.querySelectorAll('.formList').forEach((formElement, index) => {
        initializeForm(formElement, index);
    });

    document.getElementById('add-form').addEventListener('click', function() {
        const formList = document.querySelector('.formList').cloneNode(true);
        const formCount = formListBlock.querySelectorAll('.formList').length;

        formList.querySelectorAll('input, select').forEach(input => {
            if (input.id) {
                input.id = input.id.split('-')[0] + '-' + formCount;
            }
            input.value = ''; 
            input.classList.remove('is-valid', 'is-invalid');
        });

        const errorElementJs = formList.querySelector('.formListValidationErrorJs');
        if(errorElementJs) {
            errorElementJs.textContent = '';
        }

        const errorElement = formList.querySelector('.formListValidationError');
        if(errorElement) {
            errorElement.textContent = '';
        }

        document.getElementById('formListBlock').appendChild(formList);
        initializeForm(formList, formCount);

        // 入力フィールドの変更を監視
        formList.querySelectorAll('.price, .amount').forEach(function (input) {
            input.addEventListener('input', updateTotalPrice);
        });
    });

    formListBlock.addEventListener('input', (e) => {
        if (e.target.matches('.item, .category, .price, .amount')) {
            const formList = e.target.closest('.formList');
            const index = formList ? formList.getAttribute('data-index') : null;
            if (index !== null) {
                validateField(e.target, index);
            }
        }
    });

    formListBlock.addEventListener('change', (e) => {
        if (e.target.matches('.item, .category, .price, .amount')) {
            const formList = e.target.closest('.formList');
            const index = formList ? formList.getAttribute('data-index') : null;
            if (index !== null) {
                validateField(e.target, index);
            }
        }
    });

    inputShop.addEventListener('input', () => {
        if(shopError) {
            shopError.textContent = '';
        }
    
        if (inputShop.value.trim() === '') {
            inputShop.classList.remove('is-valid');
            inputShop.classList.add('is-invalid');
            shopErrorJs.textContent = errorTexts.shopNameRequired;
        } else {
            inputShop.classList.remove('is-invalid');
            inputShop.classList.add('is-valid');
            shopErrorJs.textContent = '';
        }
    });

    form.addEventListener("submit", function (event) {
        const inputs = form.querySelectorAll(".form-control");
        let isValid = true;

        inputs.forEach(input => {
            const formList = input.closest('.formList');
            const delFlgInput = formList ? formList.querySelector('input[name="delFlg[]"]') : null;
            if (delFlgInput && delFlgInput.value === '1') {
                return; // delFlgが1ならチェックスキップ
            }

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

    updateTotalPrice();

    function validateField(field, index) {
        const formList = field.closest('.formList');
        
        const delFlgInput = formList.querySelector('input[name="delFlg[]"]');
        if (delFlgInput && delFlgInput.value === '1') {
            return;
        }
        
        const fieldValue = field.value.trim();
        const errorContainer = formList.querySelector('.formListValidationErrorJs');

        if (!errorMessages[index]) {
            errorMessages[index] = { item: '', category: '', price: '', amount: '' };
        }

        if (field.classList.contains('item')) {
            if (!fieldValue) {
                errorMessages[index].item = errorTexts.itemRequired;
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else {
                errorMessages[index].item = '';
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        } else if (field.classList.contains('category')) {
            if (!fieldValue || fieldValue === 'default') {
                errorMessages[index].category = errorTexts.categoryRequired;
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else {
                errorMessages[index].category = '';
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        } else if (field.classList.contains('price')) {
            if (!fieldValue) {
                errorMessages[index].price = errorTexts.priceRequired;
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else if (isNaN(fieldValue) || fieldValue <= 0 || !Number.isInteger(Number(fieldValue))) {
                errorMessages[index].price = errorTexts.priceInvalid;
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else {
                errorMessages[index].price = '';
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        } else if (field.classList.contains('amount')) {
            if (!fieldValue) {
                errorMessages[index].amount = errorTexts.amountRequired;
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else if (isNaN(fieldValue) || fieldValue <= 0 || !Number.isInteger(Number(fieldValue))) {
                errorMessages[index].amount = amountInvalid;
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else {
                errorMessages[index].amount = '';
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        }

        const priorityOrder = ['item', 'category', 'price', 'amount'];

        const firstErrorMessage = priorityOrder.map(key => errorMessages[index][key]).find(msg => msg);
        if (errorContainer) {
            errorContainer.textContent = firstErrorMessage || '';
        }
    };

    function updateTotalPrice() {
        let total = 0;
        
        document.querySelectorAll('.formList').forEach(group => {
            if (group.classList.contains('removed')) return;

            let price = parseFloat(group.querySelector('.price').value) || 0;
            let amount = parseFloat(group.querySelector('.amount').value) || 1;
            total += price * amount;
        });

        document.getElementById('totalPrice').value = total;
    }

    function initializeForm(formElement, index) {
        formElement.setAttribute('data-index', index);
        errorMessages[index] = { item: '', category: '', price: '', amount: '' };

        formElement.querySelectorAll('.price, .amount').forEach(input => {
            input.addEventListener('input', updateTotalPrice);
        });

        formElement.querySelectorAll('.item, .category, .price, .amount').forEach(input => {
            input.addEventListener('input', () => validateField(input, index));
            input.addEventListener('change', () => validateField(input, index));
        });

        const removeButton = formElement.querySelector('.remove-form');
        if (removeButton) {
            removeButton.addEventListener('click', function() {
                const clickedFormElement = this.closest('.formList');
                const index = clickedFormElement.getAttribute('data-index');
                
                const visibleForms = document.querySelectorAll('.formList:not(.removed)');
                if (visibleForms.length > 1) {
                } else {
                    alert('これ以上削除できません！');
                    return;
                }
                
                delete errorMessages[index];

                const delFlgInput = clickedFormElement.querySelector('input[name="delFlg[]"]');
                if (delFlgInput) {
                    delFlgInput.value = '1';

                    clickedFormElement.querySelectorAll('input, select, textarea').forEach(el => {
                        el.disabled = true;
                    });
                }

                clickedFormElement.classList.add('removed');
                updateTotalPrice();
            });
        }
    }
});
