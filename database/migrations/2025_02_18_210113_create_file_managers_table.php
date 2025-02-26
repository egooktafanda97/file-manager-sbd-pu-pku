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
        Schema::create('file_managers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('code_clasification', 50)->index()->nullable();
            // user add
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            //user edit
            $table->unsignedBigInteger('user_edit_id')->index()->nullable();
            $table->foreign('user_edit_id')->references('id')->on('users')->onDelete('cascade');

            //user remove
            $table->unsignedBigInteger('user_remove_id')->index()->nullable();
            $table->foreign('user_remove_id')->references('id')->on('users')->onDelete('cascade');
            // password
            $table->string('password', 255)->nullable();

            $table->string('name', 255);
            $table->string('icon', 255)->nullable();
            $table->string('ext', 255)->nullable();
            $table->string('mime', 255)->nullable();
            $table->string('paths', 255)->nullable();
            $table->string('url', 300)->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->bigInteger('size')->nullable();
            $table->enum('type', ['file', 'folder']);
            // visibility
            $table->enum('visibility', ['public', 'private']);
            $table->enum('status', ['active', 'inactive']);
            // visit
            $table->bigInteger('visit')->default(0);
            $table->bigInteger('download')->default(0);
            $table->bigInteger('share')->default(0);
            $table->bigInteger('like')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Foreign key untuk parent_id agar bisa nested
            $table->foreign('parent_id')->references('id')->on('file_managers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_managers');
    }
};
