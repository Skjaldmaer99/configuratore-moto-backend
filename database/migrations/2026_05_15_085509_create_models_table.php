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
        Schema::create('models', function (Blueprint $table) {
            $table->id();
            $table->enum('brand', ['Ducati', 'KTM', 'Honda', 'Aprilia', 'Yamaha', 'Kawasaki']);
            $table->string('name');
            /* $table->string('slug')->unique(); */
            $table->enum('category', [
                'naked',
                'sport',
                'adventure',
                'touring',
                'urban',
                'scooter'
            ])->nullable();
            $table->decimal('base_price', 10, 2);
            $table->string('image')->nullable();;
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};

/* 
"models": [
    {
      "id": 1,
      "brand": "Honda",
      "name": "CB Hornet",
      "category": "naked"
    },
    {
      "id": 2,
      "brand": "Yamaha",
      "name": "MT",
      "category": "naked"
    },
    {
      "id": 3,
      "brand": "Kawasaki",
      "name": "Z",
      "category": "naked"
    },
    {
      "id": 4,
      "brand": "KTM",
      "name": "Duke",
      "category": "naked"
    },
    {
      "id": 5,
      "brand": "BMW",
      "name": "GS",
      "category": "adventure"
    },
    {
      "id": 6,
      "brand": "Honda",
      "name": "Africa Twin",
      "category": "adventure"
    },
    {
      "id": 7,
      "brand": "Aprilia",
      "name": "Tuono",
      "category": "naked"
    },
    {
      "id": 8,
      "brand": "Ducati",
      "name": "Monster",
      "category": "naked"
    },
    {
      "id": 9,
      "brand": "Triumph",
      "name": "Street Triple",
      "category": "naked"
    },
    {
      "id": 10,
      "brand": "Suzuki",
      "name": "V-Strom",
      "category": "adventure"
    }
  ],
   */