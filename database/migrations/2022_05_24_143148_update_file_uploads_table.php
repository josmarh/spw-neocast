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
        Schema::table('file_uploads', function (Blueprint $table) {
            $table->text('tags')->after('media_length')->nullable();
            $table->text('external_video_link')->after('tags')->nullable();
            $table->string('vhash', 50)->after('external_video_link')->nullable();
            $table->enum('upload_types', ['hosted video', 'external links'])->after('vhash')->nullable();
            $table->string('thumbnail', 100)->after('upload_types')->nullable();
            $table->integer('duration_seconds')->after('media_length')->nullable();
            $table->string('ai_video')->after('thumbnail')->nullable();
            $table->string('ai_video_status')->after('ai_video')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('tags');
        $table->dropColumn('external_video_link');
        $table->dropColumn('upload_types');
    }
};
