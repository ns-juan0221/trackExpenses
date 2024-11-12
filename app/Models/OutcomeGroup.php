<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomeGroup extends Model
{
    use HasFactory;

    /**
     * テーブル名の指定
     *
     * @var string
     */
    protected $table = 'outcome_groups';

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'shop',
        'totalPrice',
        'del_flg',
    ];

    /**
     * 属性に対するキャスト
     *
     * @var array
     */
    protected $casts = [
        'del_flg' => 'boolean',
        'totalPrice' => 'decimal:2',
    ];

    /**
     * リレーション - 支出アイテム
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outcomeItems()
    {
        return $this->hasMany(OutcomeItem::class, 'group_id');
    }
}
