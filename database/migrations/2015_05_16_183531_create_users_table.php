<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('role_id')->unsigned()->index('fk_users_roles1_idx');
            $table->string('full_name');
            $table->string('email')->unique('email_UNIQUE');
            $table->string('password', 60);
            $table->string('remember_token', 100)->nullable();
            $table->integer('domains_total')->default(0);
            $table->boolean('valid')->default(1);
            $table->boolean('enabled')->default(1);
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
        Schema::drop('users');
    }
}
