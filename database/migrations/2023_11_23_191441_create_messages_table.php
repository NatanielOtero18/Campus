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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->references('id')->on('users');                       
            $table->text('subject');       
            $table->text('content');           
            $table->timestamps();
        });

        Schema::table('messages', function (Blueprint $table) {
           
            $table->foreignId('parent_message_id')->nullable()->references('id')->on('messages')->onUpdate('cascade')->onDelete('cascade');                       
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
