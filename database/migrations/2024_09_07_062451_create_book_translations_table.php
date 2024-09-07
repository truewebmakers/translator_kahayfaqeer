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
        Schema::create('book_translations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('book_number')->default(0);
            $table->unsignedBigInteger('chapter')->default(0);
            $table->unsignedBigInteger('page_number')->default(0);
            $table->unsignedBigInteger('sentence')->default(0);
            $table->longText('text')->nullable();
            $table->enum('text_status',['approved','comment','user_review']);
            $table->string('urdu_audio')->nullable();
            $table->enum('urdu_audio_status',['approved','comment','user_review'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_translations');
    }
};
