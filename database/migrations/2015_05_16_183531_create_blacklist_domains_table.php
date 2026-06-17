<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlacklistDomainsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blacklist_domains', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('zone_id')->unsigned()->nullable()->index('fk_blacklist_domains_zones1_idx');
            $table->string('name', 200);
            $table->text('reason')->nullable();
            $table->boolean('enabled')->default(1);
            $table->timestamps();
            $table->unique(['zone_id','name'], 'blacklist_domains_unique');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blacklist_domains');
    }
}
