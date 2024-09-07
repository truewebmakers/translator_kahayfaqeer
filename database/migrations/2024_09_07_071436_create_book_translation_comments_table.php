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
        Schema::create('book_translation_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_translation_id');
            $table->foreign('book_translation_id')->references('id')->on('book_translations')->onDelete('cascade')->onUpdate('cascade');
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('type',['comment','reply'])->default('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_translation_comments');
    }
};
