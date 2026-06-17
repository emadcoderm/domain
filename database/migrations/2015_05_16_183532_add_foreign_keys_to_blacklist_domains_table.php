<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBlacklistDomainsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blacklist_domains', function (Blueprint $table) {
            $table->foreign('zone_id', 'fk_blacklist_domains_zones1')->references('id')->on('zones')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blacklist_domains', function (Blueprint $table) {
            $table->dropForeign('fk_blacklist_domains_zones1');
        });
    }
}
