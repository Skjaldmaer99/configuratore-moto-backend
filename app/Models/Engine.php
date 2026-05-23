<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    protected $table = 'engine_variants';

    protected $fillable = [
        'model_id',
        'name',
        'displacement_cc',
        'cylinders',
        'engine_type',
        'horsepower',
        'gearbox',
        'fuel_type',
        'extra_price'
    ];

    public function model()
    {
        return $this->belongsTo(Modello::class, 'model_id');
    }

    public function configurations()
    {
        return $this->hasMany(Configuration::class, 'engine_variant_id');
    }
}