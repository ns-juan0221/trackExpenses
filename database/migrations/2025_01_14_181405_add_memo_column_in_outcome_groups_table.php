<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class addMemoColumnInOutcomeGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('outcome_groups', function (Blueprint $table) {
            $table->text('memo')->after('totalPrice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('outcome_groups', function (Blueprint $table) {
            $table->dropColumn('memo');
        });
    }
};
