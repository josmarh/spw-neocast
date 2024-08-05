<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('video_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id');
            $table->string('timezone');
            $table->datetime('scheduled_at');
            $table->unSignedBigInteger('channel');
            $table->string('video_source');
            $table->text('scheduled_videos')->nullable();
            $table->string('ai_keyword')->nullable();
            $table->longText('ai_content')->nullable();
            $table->string('ai_actor_id')->nullable();
            $table->string('ai_video_id')->nullable();
            $table->string('ai_video_status')->nullable();
            $table->string('status');
            $table->unSignedBigInteger('user_id');
            $table->timestamps();
            $table->index(['batch_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_schedules');
    }
};
