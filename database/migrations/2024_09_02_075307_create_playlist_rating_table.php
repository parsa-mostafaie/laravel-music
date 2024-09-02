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
        Schema::create('playlist_rating', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('playlist_id');
            $table->tinyInteger('rate');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table
                ->foreign('playlist_id')
                ->references('id')
                ->on('playlists')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unique(['user_id', 'playlist_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_rating');
    }
};
