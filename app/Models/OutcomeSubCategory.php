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

    public $timestamps = false; // Laravelの自動タイムスタンプ管理を無効化

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
     * リレーション - 支出中カテゴリ
     * 各SubCategoryは1つのMainCategoryに属する
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mainCategory()
    {
        return $this->belongsTo(OutcomeMainCategory::class);
    }

    /**
     * リレーション - 支出アイテム
     * 各SubCategoryは複数のExpenseItemを持つ
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function OutcomeItems()
    {
        return $this->hasMany(OutcomeItem::class);
    }
}
