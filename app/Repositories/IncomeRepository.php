<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class IncomeRepository {
    /**
     * ユーザーIDから収入データを取得する
     *
     * @param int $userId
     * @return array
     */
    public function getByUserId(int $userId) {
        return DB::select("
            SELECT 
                i.id, i.date, i.amount, i.category_id, ic.name, i.memo, i.user_id, i.del_flg, 
                '-' AS shop, 'income' AS type
            FROM incomes i
            LEFT JOIN income_categories ic ON i.category_id = ic.id
            WHERE i.del_flg = 0 AND user_id = :userId
        ", ['userId' => $userId]);
    }

    /**
     * IDから収入データを取得する
     *
     * @param int $id
     * @param int $userId
     * @return object|null
     */
    public function getById(int $id, int $userId) {
        return DB::selectOne("
            SELECT 
                i.id, i.date, i.amount, i.category_id, ic.name AS category_name, i.memo, i.user_id, i.del_flg
            FROM incomes i
            LEFT JOIN income_categories ic ON i.category_id = ic.id
            WHERE i.del_flg = 0 AND i.id = :id AND user_id = :userId
        ", ['id' => $id, 'userId' => $userId]);
    }

    /**
     * ユーザーIDから最近のアイテムを取得する
     *
     * @param int $userId
     * @return array
     */
    public function getRepresentativeItemsByUserId(int $userId) {
        return DB::select("
            SELECT 
                i.id, i.date, i.amount, ic.name AS m_category_name, '-' AS s_category_name,
            'income' AS type
            FROM incomes i
            LEFT JOIN income_categories ic ON i.category_id = ic.id
            WHERE i.del_flg = 0 AND user_id = :userId
        ", ['userId' => $userId]);
    }
}