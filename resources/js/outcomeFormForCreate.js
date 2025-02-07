let formCount = 1;

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
    //最初のカテゴリ<select>にプレースホルダーを追加
    const initialCategorySelect = document.querySelector('.formList select');
    let formCount = document.querySelectorAll('.formList').length;
    const formListBlock = document.querySelector('#formListBlock');

    if (initialCategorySelect) {
        var placeholderOption = document.createElement('option');
        placeholderOption.value = '';
        placeholderOption.textContent = 'カテゴリ';
        placeholderOption.setAttribute('selected', 'selected');
        initialCategorySelect.prepend(placeholderOption);
    }

    document.getElementById('add-form').addEventListener('click', function() {
        // 現在のフォームグループを取得して複製
        var formList = document.querySelector('.formList').cloneNode(true);

        formList.querySelectorAll('input').forEach(function(input) {
            if(input.id) {
                input.id = input.id.split('-')[0] + '-' + formCount;
            }
            input.value = ''; 
            input.classList.remove('is-valid', 'is-invalid');
        });

        formList.querySelectorAll('select').forEach(function(select) {
            if(select.id) {
                select.id = select.id.split('-')[0] + '-' + formCount;
            }
            select.selectedIndex = 0;
            select.classList.remove('is-valid', 'is-invalid');
        });

        const errorElementJs = formList.querySelector('.formListValidationErrorJs');
        if(errorElementJs) {
            errorElementJs.textContent = '';
        }

        const errorElement = formList.querySelector('.formListValidationError');
        if(errorElement) {
            errorElement.textContent = '';
        }

        const removeButton = formList.querySelector('.remove-form');
        if(removeButton) {
            removeButton.addEventListener('click', function() {
                let formCount = document.querySelectorAll('.formList').length;
        
                if (formCount > 1) {
                    this.closest('.formList').remove();
                    formCount--;
                    updateTotalPrice(); 
                } else {
                    alert('これ以上削除できません！');
                }
            });
        }

        // 入力フィールドの変更を監視
        formList.querySelectorAll('.price, .amount').forEach(function (input) {
            input.addEventListener('input', updateTotalPrice);
        });

        // 新しいフォームグループをフォームコンテナに追加
        document.getElementById('formListBlock').appendChild(formList);
        
        formCount++; // カウンターをインクリメント
    });

    // 初期フォームの監視を設定
    document.querySelectorAll('.price, .amount').forEach(function (input) {
        input.addEventListener('input', updateTotalPrice);
    });

    formListBlock.addEventListener('input', (e) => {
        if (e.target.matches('.item, .price, .amount, .category')) {
            validateField(e.target);
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
                errorMessage = '品目を入力してください';
            }
        } else if (field.classList.contains('category')) {
            if (!fieldValue || fieldValue === 'default') {
                errorMessage = 'カテゴリを選択してください';
            }
        } else if (field.classList.contains('price')) {
            if (!fieldValue) {
                errorMessage = '金額を入力してください';
            } else if (isNaN(fieldValue) || fieldValue <= 0) {
                errorMessage = '正しい金額を入力してください';
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
});