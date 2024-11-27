let formCount = 1; // フォーム数をカウントする変数

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formContainer').addEventListener('input', function() {
        updateTotalPrice();
    });

    // フォーム追加処理
    document.getElementById('add-form').addEventListener('click', function() {
    // 現在のフォームグループを取得して複製
    var formList = document.querySelector('.formList').cloneNode(true);

    // 入力フィールドをクリアする
    formList.querySelectorAll('input').forEach(function(input) {
        input.id = input.id + '-' + formCount;  // idにカウントを付与してユニークにする
        input.value = '';  // フィールドを空にする
    });

    // 削除ボタンのイベントも再設定
    formList.querySelector('.remove-form').addEventListener('click', function() {
        var formCount = document.querySelectorAll('.formList').length;

        // フォームが2つ以上の場合のみ削除を許可
        if (formCount > 1) {
            this.closest('.formList').remove();
            updateTotalPrice(); // 削除後に合計を更新
        } else {
            alert('これ以上削除できません！');
        }
    });

    // 新しいフォームグループをフォームコンテナに追加
    document.getElementById('formListBlock').appendChild(formList);
    formCount++; // カウンターをインクリメント
    })

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
