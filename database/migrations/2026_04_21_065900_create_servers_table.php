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
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hostname')->nullable();
            $table->string('ip_address');
            $table->string('location')->nullable();
            $table->string('provider')->nullable();
            $table->string('os')->nullable();
            $table->enum('status', ['online', 'offline', 'warning'])->default('offline');
            $table->timestamp('last_seen_at')->nullable();
            $table->string('api_token')->unique()->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('last_seen_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
