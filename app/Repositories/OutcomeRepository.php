<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class OutcomeRepository
{
    /**
     * 指定したユーザーの過去6ヶ月分の月ごとの合計を取得
     *
     * @param int $userId
     * @return \Illuminate\Support\Collection
     */
    public function getMonthlyHalfYear(int $userId) {
        return DB::table('outcome_groups')
            ->select(DB::raw("DATE_FORMAT(date, '%Y年%m月') AS month"), DB::raw("ROUND(SUM(totalPrice), 0) AS total_sum"))
            ->where('user_id', $userId)
            ->where(function($query) {
                $query->whereBetween('date', [
                    DB::raw('DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), "%Y-%m-01")'),
                    DB::raw('LAST_DAY(CURDATE())')
                ])
                ->orWhereBetween('date', [
                    DB::raw('DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 17 MONTH), "%Y-%m-01")'),
                    DB::raw('LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 12 MONTH))')
                ]);
            })
            ->where('del_flg', 0)
            ->groupBy(DB::raw("DATE_FORMAT(date, '%Y年%m月')"))
            ->orderBy('month', 'ASC')
            ->get();
    }

    public function getSixItems(int $userId) {
        return DB::select("
            WITH latest_items AS (
                SELECT
                    oi.id,oi.user_id,oi.group_id,oi.date,oi.item,oi.price,oi.memo,oi.m_category_id,oi.s_category_id,og.shop,og.totalPrice,ROW_NUMBER() OVER (PARTITION BY oi.group_id ORDER BY oi.date DESC) AS rn
                FROM
                    outcome_items AS oi
                JOIN
                    outcome_groups AS og
                ON
                    oi.group_id = og.id
                WHERE
                    oi.user_id = :user_id AND oi.del_flg = 0 AND og.del_flg = 0
            )
            SELECT
                li.id,li.user_id,li.group_id,li.date,li.item,li.price,li.memo,li.shop,li.totalPrice,li.m_category_id,mcat.name AS m_category_name,li.s_category_id,scat.name AS s_category_name
            FROM
                latest_items AS li
            LEFT JOIN
                outcome_main_categories AS mcat ON li.m_category_id = mcat.id
            LEFT JOIN
                outcome_sub_categories AS scat ON li.s_category_id = scat.id
            WHERE
                li.rn = 1
            ORDER BY
                li.date DESC
            LIMIT 6
        ", ['user_id' => $userId]);
    }
}
