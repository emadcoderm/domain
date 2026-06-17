<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function ($table) {
            $table->boolean('captcha_on_register')->default(0);
            $table->boolean('captcha_on_login')->default(0);
            $table->string('google_analytics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function ($table) {
            $table->dropColumn('captcha_on_register');
            $table->dropColumn('captcha_on_login');
            $table->dropColumn('google_analytics');
        });
    }
}
