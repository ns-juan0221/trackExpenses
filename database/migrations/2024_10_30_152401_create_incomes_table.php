<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id(); // id
            $table->date('date'); // date
            $table->decimal('amount', 10, 2); // amount
            $table->unsignedBigInteger('category_id'); // category_id
            $table->text('memo')->nullable(); // memo
            $table->unsignedBigInteger('user_id'); // user_id
            $table->timestamps(); // created_at, updated_at
            $table->tinyInteger('del_flg')->default(0); // del_flg

            // 外部キー制約を追加する場合（例：user_idとcategory_id）
            $table->foreign('category_id')->references('id')->on('income_categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incomes');
    }
}
