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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('model_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('engine_variant_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('color_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->decimal('total_price', 10, 2)->default(0);
            $table->integer('current_step')->default(1);
            $table->enum('status', [
                'draft',
                'completed',
                'quoted',
                'abandoned'
            ])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
