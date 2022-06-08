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
        Schema::create('channel_playlists', function (Blueprint $table) {
            $table->id();
            $table->string('channel_hash', 50);
            $table->unSignedBigInteger('video_id');
            $table->string('video_thumbnail')->nullable();
            $table->bigInteger('views')->default(0);
            $table->timestamps();
            $table->index(['channel_hash', 'video_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel_playlists');
    }
};
