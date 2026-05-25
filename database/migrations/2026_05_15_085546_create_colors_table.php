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
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')
            ->constrained()
            ->cascadeOnDelete();
            $table->string('name');
            $table->string('hex_code', 7);
            $table->string('image')->nullable();
            $table->decimal('extra_price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_colors');
    }
};
