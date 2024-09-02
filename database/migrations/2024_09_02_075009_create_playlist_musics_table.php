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
        Schema::create('playlist_musics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id');
            $table->foreignId('music_id');
            $table->timestamps();

            $table->foreign('playlist_id')
                ->references('id')
                ->on('playlists')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('music_id')
                ->references('id')
                ->on('musics')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->unique(['music_id', 'playlist_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_musics');
    }
};
