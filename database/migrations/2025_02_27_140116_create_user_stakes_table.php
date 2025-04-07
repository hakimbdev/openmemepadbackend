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
        Schema::create('user_stakes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('staking_pool_id')->constrained()->onDelete('cascade');
            $table->decimal('amount_staked', 18, 8);
            $table->decimal('reward', 18, 8)->default(0);
            $table->timestamp('staked_at')->useCurrent();
            $table->timestamp('unstake_at')->nullable(); // When user withdraws
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_stakes');
    }
};
