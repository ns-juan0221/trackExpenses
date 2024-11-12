<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomeItem extends Model
{
    use HasFactory;

    /**
     * テーブル名の指定
     *
     * @var string
     */
    protected $table = 'outcome_items';

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'date',
        'item',
        'm_category_id',
        's_category_id',
        'price',
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
        'price' => 'decimal:2',
    ];

    /**
     * リレーション - グループ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(OutcomeGroup::class, 'group_id');
    }

    /**
     * リレーション - 中カテゴリ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mCategory()
    {
        return $this->belongsTo(OutcomeMainCategory::class, 'm_category_id');
    }

    /**
     * リレーション - 小カテゴリ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sCategory()
    {
        return $this->belongsTo(OutcomeSubCategory::class, 's_category_id');
    }
}
