<?php

class Income
{
    private $date;      // 収入の日付
    private $amount;    // 収入の金額
    private $category;  // 収入のカテゴリ（例: 給与、副収入など）
    private $memo;      // メモ（任意）

    // コンストラクタ
    public function __construct($date, $amount, $category, $memo = "") {
        $this->date = $date;
        $this->amount = $amount;
        $this->category = $category;
        $this->memo = $memo;
    }

    // ゲッター・セッター

    // 日付
    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    // 金額
    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    // カテゴリ
    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    // メモ
    public function getMemo() {
        return $this->memo;
    }

    public function setMemo($memo) {
        $this->memo = $memo;
    }

    // 収入の詳細表示
    public function displayIncome() {
        return "日付: " . $this->date . ", 金額: " . $this->amount .
               ", カテゴリ: " . $this->category . ", メモ: " . $this->memo;
    }

    // 金額のバリデーション
    public function isValidAmount() {
        return $this->amount > 0;  // 金額が正の値か確認
    }
}

?>
