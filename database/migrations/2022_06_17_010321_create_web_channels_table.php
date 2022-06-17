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
        Schema::create('web_channels', function (Blueprint $table) {
            $table->id();
            $table->string('whash', 26);
            $table->unSignedBigInteger('channel_id');
            $table->timestamps();
            $table->index(['whash', 'channel_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_channels');
    }
};
