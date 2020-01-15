<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name_user', 'fullname');
            $table->renameColumn('email_user', 'email');
            $table->renameColumn('phon_user', 'phone');
            $table->renameColumn('sex_user', 'gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('fullname', 'name_user');
            $table->renameColumn('email', 'email_user');
            $table->renameColumn('phone', 'phon_user');
            $table->renameColumn('gender', 'sex_user');
        });
    }
}
