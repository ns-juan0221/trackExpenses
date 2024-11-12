<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomeSubCategory extends Model
{
    use HasFactory;

    protected $table = 'outcome_sub_categories';

    protected $fillable = [
        'main_category_id',
        'name',
        'del_flg',
    ];

    protected $casts = [
        'del_flg' => 'boolean',
    ];

    /**
     * リレーション - 中カテゴリ
     * 各SubCategoryは1つのMainCategoryに属する
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mainCategory()
    {
        return $this->belongsTo(OutcomeMainCategory::class, 'main_category_id');
    }

    /**
     * リレーション - 支出アイテム
     * 各SubCategoryは複数のExpenseItemを持つ
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function OutcomeItems()
    {
        return $this->hasMany(ExpenseItem::class, 's_category_id');
    }
}
