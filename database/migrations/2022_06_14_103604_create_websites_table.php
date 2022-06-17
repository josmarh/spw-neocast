<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('channel')->nullable();
            $table->string('url_path', 50);
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->enum('header', ['show','hide']);
            $table->enum('page_layout', ['fixed','full']);
            $table->string('bg_color', 8);
            $table->string('font_color', 8);
            $table->smallInteger('autoplay');
            $table->smallInteger('volume');
            $table->smallInteger('controls');
            $table->smallInteger('content_title');
            $table->smallInteger('share_button');
            $table->string('footer_text')->nullable();
            $table->text('seo_site_meta')->nullable();
            $table->string('whash', 26);
            $table->unSignedBigInteger('user_id');
            $table->timestamps();
            $table->index(['whash']);
            $table->unique(['url_path']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('websites');
    }
};
