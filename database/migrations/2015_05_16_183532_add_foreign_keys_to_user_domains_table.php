<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserDomainsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_domains', function (Blueprint $table) {
            $table->foreign('user_id', 'fk_user_domains_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign('zone_id', 'fk_user_domains_zones1')->references('id')->on('zones')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_domains', function (Blueprint $table) {
            $table->dropForeign('fk_user_domains_users1');
            $table->dropForeign('fk_user_domains_zones1');
        });
    }
}
