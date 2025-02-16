<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomeGroup extends Model {
    use HasFactory;

    /**
     * テーブル名の指定
     *
     * @var string
     */
    protected $table = 'outcome_groups';

    public $timestamps = false;

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id',  
        'date',
        'shop',
        'totalPrice',
        'memo',  
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
        return $this->hasMany(OutcomeItem::class);
    }

    /**
     * リレーション - ユーザー
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
