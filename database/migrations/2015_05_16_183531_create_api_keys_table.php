<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApiKeysTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('fk_api_keys_users1_idx');
            $table->string('cf_id', 32);
            $table->string('api_key', 128);
            $table->string('email');
            $table->boolean('enabled')->default(1);
            $table->smallInteger('access_count')->unsigned()->nullable();
            $table->dateTime('reseted_at')->nullable();
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
        Schema::drop('api_keys');
    }
}
