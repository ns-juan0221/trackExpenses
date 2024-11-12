<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutcomeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outcome_items', function (Blueprint $table) {
            $table->id(); // id
            $table->unsignedBigInteger('group_id'); // group_id
            $table->date('date'); // date
            $table->string('item'); // item
            $table->unsignedBigInteger('m_category_id'); // m_category_id
            $table->unsignedBigInteger('s_category_id'); // s_category_id
            $table->decimal('price', 10, 2); // price
            $table->text('memo')->nullable(); // memo
            $table->timestamps(); // created_at, updated_at
            $table->tinyInteger('del_flg')->default(0); // del_flg

            // 外部キー制約
            $table->foreign('group_id')->references('id')->on('outcome_groups')->onDelete('cascade');
            $table->foreign('m_category_id')->references('id')->on('outcome_main_categories')->onDelete('cascade');
            $table->foreign('s_category_id')->references('id')->on('outcome_sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outcome_items');
    }
}
