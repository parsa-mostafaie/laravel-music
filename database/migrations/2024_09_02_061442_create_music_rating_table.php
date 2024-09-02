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
        Schema::create('music_rating', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('music_id');
            $table->tinyInteger('rate');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table
                ->foreign('music_id')
                ->references('id')
                ->on('musics')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unique(['user_id', 'music_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_rating');
    }
};
