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
        Schema::create('engine_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->integer('displacement_cc');
            $table->integer('cylinders');
            $table->string('engine_type');
            $table->integer('horsepower');
            $table->enum('gearbox', ['manuale', 'semi-automatico', 'automatico', 'DCT'])->nullable();
            $table->enum('fuel_type', ['benzina', 'diesel', 'elettrica'])->default('benzina');
            $table->decimal('extra_price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engine_variants');
    }
};

/* 
  "engine_variants": [
    {
      "id": 1,
      "model_id": 1,
      "variant_name": "500",
      "full_name": "CB500 Hornet",
      "displacement_cc": 471,
      "cylinders": 2,
      "engine_type": "bicilindrico parallelo",
      "horsepower": 47,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 6990
    },
    {
      "id": 2,
      "model_id": 1,
      "variant_name": "750",
      "full_name": "CB750 Hornet",
      "displacement_cc": 755,
      "cylinders": 2,
      "engine_type": "bicilindrico parallelo",
      "horsepower": 92,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 8990
    },

    {
      "id": 3,
      "model_id": 2,
      "variant_name": "03",
      "full_name": "MT-03",
      "displacement_cc": 321,
      "cylinders": 2,
      "engine_type": "bicilindrico parallelo",
      "horsepower": 42,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 6499
    },
    {
      "id": 4,
      "model_id": 2,
      "variant_name": "07",
      "full_name": "MT-07",
      "displacement_cc": 689,
      "cylinders": 2,
      "engine_type": "bicilindrico parallelo",
      "horsepower": 73,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 7899
    },
    {
      "id": 5,
      "model_id": 2,
      "variant_name": "09",
      "full_name": "MT-09",
      "displacement_cc": 890,
      "cylinders": 3,
      "engine_type": "tricilindrico",
      "horsepower": 119,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 10999
    },

    {
      "id": 6,
      "model_id": 3,
      "variant_name": "650",
      "full_name": "Z650",
      "displacement_cc": 649,
      "cylinders": 2,
      "engine_type": "bicilindrico parallelo",
      "horsepower": 68,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 7690
    },
    {
      "id": 7,
      "model_id": 3,
      "variant_name": "900",
      "full_name": "Z900",
      "displacement_cc": 948,
      "cylinders": 4,
      "engine_type": "4 cilindri in linea",
      "horsepower": 125,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 9990
    },

    {
      "id": 8,
      "model_id": 4,
      "variant_name": "390",
      "full_name": "390 Duke",
      "displacement_cc": 399,
      "cylinders": 1,
      "engine_type": "monocilindrico",
      "horsepower": 45,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 6490
    },
    {
      "id": 9,
      "model_id": 4,
      "variant_name": "790",
      "full_name": "790 Duke",
      "displacement_cc": 799,
      "cylinders": 2,
      "engine_type": "bicilindrico parallelo",
      "horsepower": 105,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 9990
    },
    {
      "id": 10,
      "model_id": 4,
      "variant_name": "990",
      "full_name": "990 Duke",
      "displacement_cc": 947,
      "cylinders": 2,
      "engine_type": "bicilindrico parallelo",
      "horsepower": 123,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 14990
    },

    {
      "id": 11,
      "model_id": 5,
      "variant_name": "900",
      "full_name": "F900 GS",
      "displacement_cc": 895,
      "cylinders": 2,
      "engine_type": "bicilindrico parallelo",
      "horsepower": 105,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 13950
    },
    {
      "id": 12,
      "model_id": 5,
      "variant_name": "1300",
      "full_name": "R1300 GS",
      "displacement_cc": 1300,
      "cylinders": 2,
      "engine_type": "bicilindrico boxer",
      "horsepower": 145,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 21000
    },

    {
      "id": 13,
      "model_id": 6,
      "variant_name": "1100",
      "full_name": "Africa Twin 1100",
      "displacement_cc": 1084,
      "cylinders": 2,
      "engine_type": "bicilindrico parallelo",
      "horsepower": 102,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 15990
    },
    {
      "id": 14,
      "model_id": 6,
      "variant_name": "1100 DCT",
      "full_name": "Africa Twin 1100 DCT",
      "displacement_cc": 1084,
      "cylinders": 2,
      "engine_type": "bicilindrico parallelo",
      "horsepower": 102,
      "gearbox": "dct",
      "fuel_type": "benzina",
      "base_price": 17190
    },

    {
      "id": 15,
      "model_id": 7,
      "variant_name": "660",
      "full_name": "Tuono 660",
      "displacement_cc": 659,
      "cylinders": 2,
      "engine_type": "bicilindrico parallelo",
      "horsepower": 95,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 10999
    },
    {
      "id": 16,
      "model_id": 7,
      "variant_name": "V4",
      "full_name": "Tuono V4",
      "displacement_cc": 1077,
      "cylinders": 4,
      "engine_type": "V4",
      "horsepower": 175,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 18999
    },

    {
      "id": 17,
      "model_id": 8,
      "variant_name": "937",
      "full_name": "Monster 937",
      "displacement_cc": 937,
      "cylinders": 2,
      "engine_type": "bicilindrico a L",
      "horsepower": 111,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 12490
    },

    {
      "id": 18,
      "model_id": 9,
      "variant_name": "765 R",
      "full_name": "Street Triple 765 R",
      "displacement_cc": 765,
      "cylinders": 3,
      "engine_type": "tricilindrico",
      "horsepower": 120,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 10995
    },
    {
      "id": 19,
      "model_id": 9,
      "variant_name": "765 RS",
      "full_name": "Street Triple 765 RS",
      "displacement_cc": 765,
      "cylinders": 3,
      "engine_type": "tricilindrico",
      "horsepower": 130,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 13995
    },

    {
      "id": 20,
      "model_id": 10,
      "variant_name": "650",
      "full_name": "V-Strom 650",
      "displacement_cc": 645,
      "cylinders": 2,
      "engine_type": "V-Twin",
      "horsepower": 71,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 8990
    },
    {
      "id": 21,
      "model_id": 10,
      "variant_name": "800DE",
      "full_name": "V-Strom 800DE",
      "displacement_cc": 776,
      "cylinders": 2,
      "engine_type": "bicilindrico parallelo",
      "horsepower": 84,
      "gearbox": "manuale",
      "fuel_type": "benzina",
      "base_price": 11990
    }
  ]
}
   */