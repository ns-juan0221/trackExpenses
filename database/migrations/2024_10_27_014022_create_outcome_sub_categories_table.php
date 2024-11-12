<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutcomeSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outcome_sub_categories', function (Blueprint $table) {
            $table->id(); // id
            $table->unsignedBigInteger('main_category_id'); // 中項目カテゴリへの外部キー
            $table->string('name'); // 小項目カテゴリ名
            $table->timestamps(); // 作成日時・更新日時
            $table->tinyInteger('del_flg')->default(0); // 論理削除フラグ

            // 外部キー制約
            $table->foreign('main_category_id')->references('id')->on('outcome_main_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outcome_sub_categories');
    }
}
