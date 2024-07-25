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
        Schema::create('iptv_streams', function (Blueprint $table) {
            $table->id();
            $table->string('channel')->nullable();
            $table->string('url')->nullable();
            $table->string('timeshift')->nullable();
            $table->string('http_referrer')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            $table->index('channel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iptv_streams');
    }
};
