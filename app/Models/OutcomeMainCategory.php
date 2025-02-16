<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomeMainCategory extends Model
{
    use HasFactory;

    /**
     * テーブル名の指定
     *
     * @var string
     */
    protected $table = 'outcome_main_categories';

    public $timestamps = false;

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
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
     * リレーション - 支出サブカテゴリ
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories()
    {
        return $this->hasMany(OutcomeSubCategory::class);
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
