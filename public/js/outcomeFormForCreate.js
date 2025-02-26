document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector(".needs-validation");
    const formListBlock = document.querySelector('#formListBlock');
    const initialCategorySelect = document.querySelector('.formList select');
    const initialForm = document.querySelector('.formList');
    const inputShop = document.querySelector('#inputShop');
    const shopErrorJs = document.querySelector('.shopValidationErrorJs');
    const shopError = document.querySelector('.shopValidationError');
    let formCount = 0;
    let errorMessages = {};

    if (initialForm) {
        initializeForm(initialForm, formCount);
    }

    if (initialCategorySelect) {
        let placeholderOption = document.createElement('option');
        placeholderOption.value = '';
        placeholderOption.textContent = 'カテゴリ';
        placeholderOption.setAttribute('selected', 'selected');
        initialCategorySelect.prepend(placeholderOption);
    }

    document.getElementById('add-form').addEventListener('click', function() {
        formCount++;
        const formList = document.querySelector('.formList').cloneNode(true);

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

    // 初期フォームの監視を設定
    document.querySelectorAll('.price, .amount').forEach(function (input) {
        input.addEventListener('input', updateTotalPrice);
    });

    formListBlock.addEventListener('input', (e) => {
        if (e.target.matches('.item, .category, .price, .amount')) {
            const formGroup = e.target.closest('.formList');
            const index = formGroup ? formGroup.getAttribute('data-index') : null;
            if (index !== null) {
                validateField(e.target, index);
            }
        }
    });

    formListBlock.addEventListener('change', (e) => {
        if (e.target.matches('.item, .category, .price, .amount')) {
            const formGroup = e.target.closest('.formList');
            const index = formGroup ? formGroup.getAttribute('data-index') : null;
            if (index !== null) {
                validateField(e.target, index);
            }
        }
    });

    function validateField(field, index) {
        const fieldValue = field.value.trim();
        const formGroup = field.closest('.formList');
        const errorContainer = formGroup.querySelector('.formListValidationErrorJs');

        if (!errorMessages[index]) {
            errorMessages[index] = { item: '', category: '', price: '', amount: '' };
        }

        if (field.classList.contains('item')) {
            if (!fieldValue) {
                errorMessages[index].item = '商品名を入力してください';
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else {
                errorMessages[index].item = '';
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        } else if (field.classList.contains('category')) {
            if (!fieldValue || fieldValue === 'default') {
                errorMessages[index].category = 'カテゴリを選択してください';
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else {
                errorMessages[index].category = '';
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        } else if (field.classList.contains('price')) {
            if (!fieldValue) {
                errorMessages[index].price = '金額を入力してください';
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else if (isNaN(fieldValue) || fieldValue <= 0) {
                errorMessages[index].price = '金額は1以上の半角数字で入力してください';
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else {
                errorMessages[index].price = '';
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        } else if (field.classList.contains('amount')) {
            if (!fieldValue) {
                errorMessages[index].amount = '個数を入力してください';
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else if (isNaN(fieldValue) || fieldValue <= 0) {
                errorMessages[index].amount = '個数は1以上の半角数字で入力してください';
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
                if (document.querySelectorAll('.formList').length > 1) {
                    const index = formElement.getAttribute('data-index');
                    delete errorMessages[index];
                    formElement.remove();
                    updateTotalPrice();
                } else {
                    alert('これ以上削除できません！');
                }
            });
        }
    }

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