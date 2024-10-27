let formCount = 1; // フォーム数をカウントする変数

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form-container').addEventListener('input', function() {
        updateTotalPrice();
    });

    // フォーム追加処理
    document.getElementById('add-form').addEventListener('click', function() {
    // 現在のフォームグループを取得して複製
    var formGroup = document.querySelector('.form-group').cloneNode(true);

    // 入力フィールドをクリアする
    formGroup.querySelectorAll('input').forEach(function(input) {
        input.id = input.id + '-' + formCount;  // idにカウントを付与してユニークにする
        input.value = '';  // フィールドを空にする
    });

    // 削除ボタンのイベントも再設定
    formGroup.querySelector('.remove-form').addEventListener('click', function() {
        var formCount = document.querySelectorAll('.form-group').length;

        // フォームが2つ以上の場合のみ削除を許可
        if (formCount > 1) {
            this.closest('.form-group').remove();
            updateTotalPrice(); // 削除後に合計を更新
        } else {
            alert('これ以上削除できません！');
        }
    });

    // 新しいフォームグループをフォームコンテナに追加
    document.getElementById('form-group-block').appendChild(formGroup);
    formCount++; // カウンターをインクリメント
    })

    // 合計金額を計算する関数
    function updateTotalPrice() {
        var total = 0;
        // すべてのフォームグループをループ
        document.querySelectorAll('.form-group').forEach(function(group) {
            var price = parseFloat(group.querySelector('.price').value) || 0; // 金額を取得
            var amount = parseFloat(group.querySelector('.amount').value) || 1; // 個数を取得 (デフォルト1)
            total += price * amount; // 金額 × 個数を合計
        });
        document.getElementById('totalPrice').value = total; // 合計値を表示
    }
});
