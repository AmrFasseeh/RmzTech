<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_hours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id')->unsigned();
            $table->time('sat_open_time')->nullable();
            $table->time('sat_close_time')->nullable();
            $table->boolean('is_sat_holi');

            $table->time('sun_open_time')->nullable();
            $table->time('sun_close_time')->nullable();
            $table->boolean('is_sun_holi');

            $table->time('mon_open_time')->nullable();
            $table->time('mon_close_time')->nullable();
            $table->boolean('is_mon_holi');

            $table->time('tue_open_time')->nullable();
            $table->time('tue_close_time')->nullable();
            $table->boolean('is_tue_holi');

            $table->time('wed_open_time')->nullable();
            $table->time('wed_close_time')->nullable();
            $table->boolean('is_wed_holi');

            $table->time('thu_open_time')->nullable();
            $table->time('thu_close_time')->nullable();
            $table->boolean('is_thu_holi');

            $table->time('fri_open_time')->nullable();
            $table->time('fri_close_time')->nullable();
            $table->boolean('is_fri_holi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_hours');
    }
}
