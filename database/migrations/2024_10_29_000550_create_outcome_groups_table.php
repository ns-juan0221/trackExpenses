<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutcomeGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outcome_groups', function (Blueprint $table) {
            $table->id(); // id
            $table->date('date'); // date
            $table->string('shop'); // shop
            $table->decimal('totalPrice', 10, 2); // totalPrice
            $table->timestamps(); // created_at, updated_at
            $table->tinyInteger('del_flg')->default(0); // del_flg
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outcome_groups');
    }
}
