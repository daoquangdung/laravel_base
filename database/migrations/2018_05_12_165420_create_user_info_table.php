<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('tb_user_info')){
            Schema::create('tb_user_info', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('phone')->nullable();
                $table->string('firstname')->nullable();
                $table->string('lastname')->nullable();
                $table->string('address')->nullable();
                $table->timestamp('birthday')->nullable();
                $table->string('avatar')->nullable();
                $table->string('facebook')->nullable();
                $table->text('about')->nullable();
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('tb_users');
//                $table->foreign('user_id')->references('id')->on('tb_users');
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
        Schema::dropIfExists('tb_user_info');
    }
}
