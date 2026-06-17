<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDnsRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dns_records', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('zone_id')->unsigned()->index('fk_dns_record_zones1_idx');
            $table->integer('user_domain_id')->unsigned()->nullable()->index('fk_dns_record_user_domains1_idx');
            $table->string('cf_id', 32)->nullable();
            $table->string('type', 20);
            $table->string('name', 45);
            $table->text('content');
            $table->boolean('proxiable')->nullable();
            $table->boolean('proxied')->nullable();
            $table->integer('ttl')->nullable();
            $table->boolean('locked')->nullable();
            $table->integer('priority')->nullable();
            $table->text('data', 65535)->nullable();
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
        Schema::drop('dns_records');
    }
}
