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
            $table->foreign('book_translation_id')->references('id')->on('book_translations');
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('type',['comment','reply'])->default('comment');
            $table->string('proof_read_user',5)->nullable();
            $table->string('current_user_level',10)->default(1);

            $table->enum('text_status',['approved_without_comment','approved_with_comment','reject_revise_and_resubmit','under_review','in-process'])->default('in-process');
            $table->enum('urdu_audio_status',['approved_without_comment','approved_with_comment','reject_revise_and_resubmit','under_review','in-process'])->default('in-process');
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
