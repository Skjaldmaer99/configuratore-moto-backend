<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'model_id',
        'name',
        'hex_code',
        'image',
        'extra_price'
    ];

    public function model()
    {
        /* return $this->belongsToMany(
            Modello::class,
            'model_colors',
            'color_id',
            'model_id'
        ); */
        return $this->belongsTo(Modello::class);
    }

    public function configurations()
    {
        return $this->hasMany(Configuration::class);
    }
}