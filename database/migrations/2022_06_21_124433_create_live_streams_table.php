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
        Schema::create('live_streams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('channels')->nullable();
            $table->text('stream_record')->nullable();
            $table->smallInteger('broadcast_signal');
            $table->string('stream_key');
            $table->string('live_status', 15)->nullable();
            $table->string('lhash', 32);
            $table->unSignedBiginteger('user_id');
            $table->timestamps();
            $table->index(['stream_key', 'lhash']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_streams');
    }
};
