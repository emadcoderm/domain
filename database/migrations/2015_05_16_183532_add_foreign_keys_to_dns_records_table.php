<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDnsRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dns_records', function (Blueprint $table) {
            $table->foreign('user_domain_id', 'fk_dns_record_user_domains1')->references('id')->on('user_domains')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign('zone_id', 'fk_dns_record_zones1')->references('id')->on('zones')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dns_records', function (Blueprint $table) {
            $table->dropForeign('fk_dns_record_user_domains1');
            $table->dropForeign('fk_dns_record_zones1');
        });
    }
}
