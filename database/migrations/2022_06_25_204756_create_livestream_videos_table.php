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
        Schema::create('livestream_videos', function (Blueprint $table) {
            $table->id();
            $table->string('lhash', 32);
            $table->unSignedBigInteger('video_id');
            $table->timestamps();
            $table->index(['lhash', 'video_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livestream_videos');
    }
};
