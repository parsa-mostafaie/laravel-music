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
        Schema::create('musics', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('summary')->default('');
            $table->string('lyric')->default('');

            $table->string('image')->nullable();

            $table->bigInteger('time', unsigned: true);
            $table->bigInteger('size', unsigned: true);
            $table->string('file');
            $table->integer('quality');

            $table->foreignId('artist_id');
            $table->foreignId('category_id');

            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('artist_id')
                ->references('id')
                ->on('artists')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('musics');
    }
};
