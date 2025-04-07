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
        Schema::create('liquidity_pools', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "BWS-ETH LP"
            $table->decimal('tvl', 16, 8)->default(0); // Total Value Locked
            $table->decimal('apr', 5, 2); // Annual Percentage Rate
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liquidity_pools');
    }
};
