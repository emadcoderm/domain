<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserDomainsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_domains', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('fk_user_domains_users1_idx');
            $table->integer('zone_id')->unsigned()->index('fk_user_domains_zones1_idx');
            $table->string('name', 200);
            $table->integer('domains_total')->default(0);
            $table->boolean('enabled')->default(1);
            $table->dateTime('expired_at')->nullable();
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
        Schema::drop('user_domains');
    }
}
