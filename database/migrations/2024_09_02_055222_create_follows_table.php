<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('followed_artist_id');
            $table->foreignId('following_user_id');
            $table->timestamp('created_at');

            // Relations
            $table->foreign('followed_artist_id')
                ->references('id')->on('artists')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('following_user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
