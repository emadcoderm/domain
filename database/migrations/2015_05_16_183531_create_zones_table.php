<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZonesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('api_key_id')->unsigned()->index('fk_zones_api_keys_idx');
            $table->string('cf_id', 32);
            $table->string('name', 253);
            $table->text('name_servers')->nullable();
            $table->string('status')->nullable();
            $table->boolean('paused')->nullable();
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
        Schema::drop('zones');
    }
}
