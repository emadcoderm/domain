<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            // web
            $table->string('keyword')->nullable();
            $table->string('description')->nullable();
            $table->string('page_title');
            // homepage
            $table->string('lead_text')->nullable();
            $table->string('middle_title')->nullable();
            $table->string('middle_body')->nullable();
            $table->string('footer_left_title')->nullable();
            $table->text('footer_left_body')->nullable();
            $table->string('footer_right_title')->nullable();
            $table->text('footer_right_body')->nullable();
            $table->string('footer_social_title')->nullable();
            $table->string('footer_social_facebook')->nullable();
            $table->string('footer_social_twitter')->nullable();
            $table->string('footer_social_googleplus')->nullable();
            $table->string('footer_social_pinterest')->nullable();
            $table->string('footer_social_linkedin')->nullable();
            $table->string('footer_social_instagram')->nullable();
            $table->string('footer_social_youtube')->nullable();
            // domain
            $table->integer('domain_min_chars')->default(3);
            $table->integer('domain_max_chars')->default(50);
            $table->integer('domain_registration_year')->default(1);
            $table->integer('domains_per_user')->default(3);
            $table->integer('dns_per_domain')->default(0);
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
        Schema::drop('settings');
    }
}
