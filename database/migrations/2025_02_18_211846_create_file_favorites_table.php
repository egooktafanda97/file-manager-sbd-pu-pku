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
        Schema::create('file_favorites', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            // user add
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('file_manager_id')->index();
            $table->foreign('file_manager_id')->references('id')->on('file_managers')->onDelete('cascade');

            $table->enum('type', ['favorite', 'unfavorite']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_favorites');
    }
};
