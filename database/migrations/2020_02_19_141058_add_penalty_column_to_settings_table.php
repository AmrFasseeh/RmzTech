<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPenaltyColumnToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->float('penalty_multiplier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->removeColumn('penalty_multiplier');
        });
    }
}
