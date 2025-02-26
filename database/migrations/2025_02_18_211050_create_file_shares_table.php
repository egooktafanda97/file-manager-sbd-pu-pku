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
        Schema::create('file_shares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            // user add
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //user remove
            $table->unsignedBigInteger('user_remove_id')->nullable();
            $table->foreign('user_remove_id')->references('id')->on('users')->onDelete('cascade');
            // user share
            $table->unsignedBigInteger('user_share_id')->index();
            $table->foreign('user_share_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('file_manager_id')->index();
            $table->foreign('file_manager_id')->references('id')->on('file_managers')->onDelete('cascade');

            // type share
            $table->enum('type', ['view', 'edit']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_shares');
    }
};
