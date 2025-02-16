<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomeSubCategory extends Model
{
    use HasFactory;

    /**
     * テーブル名の指定
     *
     * @var string
     */
    protected $table = 'outcome_sub_categories';

    public $timestamps = false;

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'main_category_id',
        'name',
        'del_flg',
    ];

    /**
     * 属性に対するキャスト
     *
     * @var array
     */
    protected $casts = [
        'del_flg' => 'boolean',
    ];

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
     * リレーション - 支出アイテム
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outcomeItems()
    {
        return $this->hasMany(OutcomeItem::class);
    }
}
