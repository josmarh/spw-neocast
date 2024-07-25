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
        Schema::create('iptv_channels', function (Blueprint $table) {
            $table->id();
            $table->string('channel_id')->nullable();
            $table->string('name')->nullable();
            $table->text('alt_names')->nullable();
            $table->text('network')->nullable();
            $table->text('owners')->nullable();
            $table->string('country')->nullable();
            $table->text('subdivision')->nullable();
            $table->string('city')->nullable();
            $table->text('broadcast_area')->nullable();
            $table->text('languages')->nullable();
            $table->text('categories')->nullable();
            $table->boolean('is_nsfw')->default(false);
            $table->text('launched')->nullable();
            $table->text('closed')->nullable();
            $table->text('replaced_by')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
            $table->index('channel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iptv_channels');
    }
};
