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
    public function getMonthlyHalfYear(int $userId)
    {
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
}
