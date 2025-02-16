<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CategoryRepository {
    /**
     * 支出カテゴリーを取得する
     *
     * @return array
     */
    public function getOutcomeCategories() {
        return DB::select("
            SELECT 
                m.id AS main_id,m.name AS main_name,s.id AS sub_id,s.name AS sub_name
            FROM 
                outcome_main_categories AS m
            JOIN 
                outcome_sub_categories AS s
            ON 
                m.id = s.main_category_id
            WHERE 
                m.del_flg = 0 AND s.del_flg = 0;
        ");
    }

    /**
     * 収入カテゴリーを取得する
     *
     * @return array
     */
    public function getIncomeCategories() {
        return DB::select("
            SELECT 
                id,name
            FROM 
                income_categories
            WHERE 
                del_flg = 0;
        ");
    }
}