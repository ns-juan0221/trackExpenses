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

    public $timestamps = false; // Laravelの自動タイムスタンプ管理を無効化

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
     * リレーション - 支出小カテゴリ
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories()
    {
        return $this->hasMany(OutcomeSubCategory::class);
    }

    /**
     * リレーション - 支出アイテム
     * 各MainCategoryは複数のExpenseItemを持つ
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenseItems()
    {
        return $this->hasMany(OutcomeItem::class);
    }
}
