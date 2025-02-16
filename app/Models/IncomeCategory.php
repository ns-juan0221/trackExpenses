<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;

    /**
     * テーブル名の指定
     *
     * @var string
     */
    protected $table = 'income_categories';

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
     * リレーション - 収入アイテム
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incomes() {
        return $this->hasMany(Income::class);
    }
}
