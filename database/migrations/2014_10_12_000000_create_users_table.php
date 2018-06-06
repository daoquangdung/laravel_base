<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('tb_users')){
            Schema::create('tb_users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('username');
                $table->string('email')->unique();
                $table->string('password');
                $table->tinyInteger('permission')->default(1);
                $table->tinyInteger('deleted')->default(0);
                $table->rememberToken();
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_users');
    }
}
