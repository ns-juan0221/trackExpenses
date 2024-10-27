<?php

namespace App\Models;

class Outcome {
    private $date;              // 日付
    private $shop;              // お店の名前
    private $items = [];        // 品目リスト（複数の品目を管理）
    private $totalPrice = 0;

    // 日時情報
    private $createdAt;
    private $updatedAt;

    public function __construct($date, $shop)
    {
        $this->date = $date;
        $this->shop = $shop;
        $this->createdAt = date('Y-m-d H:i:s');
    }

    // ゲッター・セッター
    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getShop() {
        return $this->shop;
    }

    public function setShop($shop) {
        $this->shop = $shop;
    }

    // 品目追加メソッド
    public function addItem($itemName, $category, $price, $amount) {
        $this->items[] = [
            'item' => $itemName,
            'category' => $category,
            'price' => $price,
            'amount' => $amount,
        ];
    }

    // 全品目取得メソッド
    public function getItems() {
        return $this->items;
    }

    // 合計金額計算
    public function calculateTotalPrice() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['price'] * $item['amount'];
        }
        return $total;
    }

    // 支出内容の表示メソッド（デバッグ用）
    public function displayExpense() {
        $output = "日付: " . $this->date . ", お店: " . $this->shop . "\n";
        $output .= "品目リスト:\n";
        foreach ($this->items as $item) {
            $output .= "  品目: " . $item['item'] . ", カテゴリ: " . $item['category'] . ", 金額: " . $item['price'] . ", 個数: " . $item['amount'] . "\n";
        }
        $output .= "合計金額: " . $this->calculateTotalPrice() . "\n";
        return $output;
    }
}

?>
