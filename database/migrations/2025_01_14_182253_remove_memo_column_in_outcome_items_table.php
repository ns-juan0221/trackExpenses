<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class removeMemoColumnInOutcomeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('outcome_items', function (Blueprint $table) {
            $table->dropColumn('memo'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('outcome_items', function (Blueprint $table) {
            $table->string('memo')->after('amount')->nullable(); 
        });
    }
};
