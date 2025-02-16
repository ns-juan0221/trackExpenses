<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class OutcomeRepository {
    /**
     * ユーザーIDから支出グループデータを取得する
     *
     * @param int $userId
     * @return array
     */
    public function getGroupsByUserId(int $userId) {
        return DB::select("
            SELECT 
                id, date, shop, totalPrice AS amount, memo, user_id, del_flg, 
                '-' AS category_id, '-' AS name, 'outcome' AS type
            FROM outcome_groups
            WHERE del_flg = 0 AND user_id = :userId
        ", ['userId' => $userId]);
    }

    /**
     * ユーザーIDとグループIDから支出アイテムデータを取得する
     *
     * @param int $userId
     * @param int $groupId
     * @return array
     */
    public function getItemsByGroupId(int $userId, int $groupId) {
        return DB::select("
            SELECT
                oi.id,oi.group_id,oi.date,oi.item,oi.price,oi.amount,(oi.price * oi.amount) AS totalPrice,oi.m_category_id,oi.s_category_id,mCat.name AS m_category_name,sCat.name AS s_category_name
            FROM
                outcome_items AS oi
            LEFT JOIN
                outcome_main_categories AS mCat ON oi.m_category_id = mCat.id
            LEFT JOIN
                outcome_sub_categories AS sCat ON oi.s_category_id = sCat.id
            WHERE
                oi.user_id = :userId AND oi.group_id = :groupId AND oi.del_flg = 0
        ", ['userId' => $userId, 'groupId' => $groupId]);
    }

    /**
     * ユーザーIDとグループIDから支出グループデータを取得する。
     *
     * @param int $userId
     * @param int $groupId
     * @return object|null
     */
    public function getGroupByGroupId(int $userId, int $groupId) {
        return DB::selectOne("
            SELECT
                og.id,og.date,og.shop,og.totalPrice,og.memo
            FROM
                outcome_groups AS og
            WHERE
                og.user_id = :userId AND og.id = :groupId AND og.del_flg = 0
        ", ['userId' => $userId, 'groupId' => $groupId]);
    }

    /**
     * 過去半年間の月別支出合計を取得する
     *
     * @param int $userId
     * @return array
     */
    public function getMonthlyHalfYear(int $userId) {
        return DB::select("
            SELECT 
                DATE_FORMAT(date, '%Y年%m月') AS month,
                ROUND(SUM(totalPrice), 0) AS total_sum
            FROM 
                outcome_groups
            WHERE 
                user_id = :userId AND del_flg = 0 AND (
                    (date BETWEEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), '%Y-%m-01') 
                            AND LAST_DAY(CURDATE()))
                    OR
                    (date BETWEEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 17 MONTH), '%Y-%m-01') 
                            AND LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 12 MONTH)))
                )
            GROUP BY 
                DATE_FORMAT(date, '%Y年%m月')
            ORDER BY 
                month ASC
        ", ['userId' => $userId]);
    }

    /**
     * ユーザーIDから最近の支出アイテムデータを取得する
     *
     * @param int $userId
     * @return array
     */
    public function getRepresentativeItemsByUserId(int $userId) {
        return DB::select("
            WITH latest_items AS (
                SELECT
                    og.id,oi.date,oi.item,oi.price,oi.m_category_id,oi.s_category_id,og.shop,og.totalPrice,ROW_NUMBER() OVER (PARTITION BY oi.group_id ORDER BY oi.date DESC) AS rn
                FROM
                    outcome_items AS oi
                JOIN
                    outcome_groups AS og
                ON
                    oi.group_id = og.id
                WHERE
                    oi.user_id = :userId AND oi.del_flg = 0 AND og.del_flg = 0
            )
            SELECT
                li.id,li.date,li.totalPrice AS amount,mCat.name AS m_category_name,sCat.name AS s_category_name,
                'outcome' as type
            FROM
                latest_items AS li
            LEFT JOIN
                outcome_main_categories AS mCat ON li.m_category_id = mCat.id
            LEFT JOIN
                outcome_sub_categories AS sCat ON li.s_category_id = sCat.id
            WHERE
                li.rn = 1
            ORDER BY
                li.date DESC
        ", ['userId' => $userId]);
    }
}
