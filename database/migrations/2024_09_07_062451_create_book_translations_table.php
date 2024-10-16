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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('book_number')->default(0);
            $table->unsignedBigInteger('chapter')->default(0);
            $table->unsignedBigInteger('page_number')->default(0);
            $table->unsignedBigInteger('sentence')->default(0);
            $table->longText('text')->nullable();
            $table->longText('supporting_language')->nullable();


            $table->longText('urdu')->nullable();
            $table->longText('english')->nullable();
            $table->longText('arabic')->nullable();
            $table->longText('hindi')->nullable();
            $table->longText('indonesian')->nullable();
            $table->longText('bengali')->nullable();
            $table->longText('persian')->nullable();
            $table->longText('turkish')->nullable();


            $table->string('urdu_audio')->nullable();
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
