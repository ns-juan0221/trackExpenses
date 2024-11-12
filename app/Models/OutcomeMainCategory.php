<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomeMainCategory extends Model
{
    use HasFactory;

    protected $table = 'outcome_main_categories';

    protected $fillable = [
        'name',
        'del_flg',
    ];

    protected $casts = [
        'del_flg' => 'boolean',
    ];

    /**
     * リレーション - 小項目カテゴリ
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories()
    {
        return $this->hasMany(OutcomeSubCategory::class, 'main_category_id');
    }

    /**
     * リレーション - 支出アイテム
     * 各MainCategoryは複数のExpenseItemを持つ
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenseItems()
    {
        return $this->hasMany(OutcomeItem::class, 'm_category_id');
    }
}
