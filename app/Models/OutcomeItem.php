<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomeItem extends Model {
    use HasFactory;

    /**
     * テーブル名の指定
     *
     * @var string
     */
    protected $table = 'outcome_items';

    public $timestamps = false;

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'group_id',
        'date',
        'item',
        'm_category_id',
        's_category_id',
        'price',
        'amount',
        'del_flg',
    ];

    /**
     * 属性に対するキャスト
     *
     * @var array
     */
    protected $casts = [
        'del_flg' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * リレーション - ユーザー
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * リレーション - 支出グループ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outcomeGroup()
    {
        return $this->belongsTo(OutcomeGroup::class);
    }

    /**
     * リレーション - 支出メインカテゴリ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mainCategory()
    {
        return $this->belongsTo(OutcomeMainCategory::class);
    }

    /**
     * リレーション - 支出サブカテゴリ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory()
    {
        return $this->belongsTo(OutcomeSubCategory::class);
    }
}
