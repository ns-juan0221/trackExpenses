document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector(".needs-validation");
    const formListBlock = document.querySelector('#formListBlock');
    const inputShop = document.querySelector('#inputShop');
    const shopErrorJs = document.querySelector('.shopValidationErrorJs');
    const shopError = document.querySelector('.shopValidationError');

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

    // フィールドのバリデーション関数
    function validateField(field) {
        const fieldValue = field.value.trim();
        const errorContainer = field.closest('.formList').querySelector('.validationError');
        let errorMessage = '';

        // フィールドごとのバリデーション
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

        // エラーの表示・クリア
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
        return !errorMessage; // エラーがなければtrue
    };

    // 合計金額を計算する関数
    function updateTotalPrice() {
        var total = 0;
        
        // すべてのフォームグループをループ
        document.querySelectorAll('.formList').forEach(function(group) {
            var price = parseFloat(group.querySelector('.price').value) || 0; // 金額を取得
            var amount = parseFloat(group.querySelector('.amount').value) || 1; // 個数を取得 (デフォルト1)
            total += price * amount; // 金額 × 個数を合計
        });
        document.getElementById('totalPrice').value = total; // 合計値を表示
    }

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