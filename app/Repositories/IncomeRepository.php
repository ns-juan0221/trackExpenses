<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class IncomeRepository {
    public function getByUserId($userId) {
        return DB::select("
            SELECT 
                i.id, i.date, i.amount, i.category_id, ic.name, i.memo, i.user_id, i.del_flg, 
                '-' AS shop, 'income' AS type
            FROM incomes i
            LEFT JOIN income_categories ic ON i.category_id = ic.id
            WHERE i.del_flg = 0 AND user_id = :userId
        ", ['userId' => $userId]);
    }
}