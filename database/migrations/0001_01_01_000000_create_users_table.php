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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telegram_id')->nullable()->unique(); // Telegram user ID
            $table->string('telegram_username')->nullable(); // Telegram username
            $table->string('telegram_chat_id')->nullable(); // Telegram chat ID
            $table->string('wallet_id')->nullable(); // Telegram chat ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    
};
