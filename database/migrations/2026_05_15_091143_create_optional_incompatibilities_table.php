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
        Schema::create('optional_incompatibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('optional_1_id')
                ->constrained('optionals')
                ->cascadeOnDelete();
            $table->foreignId('optional_2_id')
                ->constrained('optionals')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optional_incompatibilities');
    }
};
