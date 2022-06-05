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
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('schedule_duration', 10)->nullable();
            $table->string('start_time', 10)->nullable();
            $table->unSignedBigInteger('timezone')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_link')->nullable();
            $table->string('logo_position', 6);
            $table->string('color', 15);
            $table->string('twitter', 50)->nullable();
            $table->string('privacy', 50);
            $table->text('privacy_domain')->nullable();
            $table->text('ad_tag_url')->nullable();
            $table->string('channel_type', 25);
            $table->string('channel_hash', 50);
            $table->unSignedBigInteger('user_id');
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
        Schema::dropIfExists('channels');
    }
};
