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
        Schema::create('server_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->constrained()->onDelete('cascade');
            $table->decimal('cpu_usage', 5, 2)->nullable();
            $table->decimal('memory_usage', 5, 2)->nullable();
            $table->integer('memory_total')->nullable();
            $table->integer('memory_used')->nullable();
            $table->decimal('disk_usage', 5, 2)->nullable();
            $table->integer('disk_total')->nullable();
            $table->integer('disk_used')->nullable();
            $table->decimal('network_in', 10, 2)->nullable();
            $table->decimal('network_out', 10, 2)->nullable();
            $table->string('load_average')->nullable();
            $table->integer('uptime')->nullable();
            $table->timestamp('recorded_at')->useCurrent();
            
            $table->index(['server_id', 'recorded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_metrics');
    }
};
