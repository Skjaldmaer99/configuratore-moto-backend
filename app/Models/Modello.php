<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modello extends Model
{
    protected $table = 'models';

    protected $fillable = [
        'brand',
        'name',
        'category',
        'base_price',
        'image',
        'description'
    ];

    public function engines()
    {
        return $this->hasMany(Engine::class,'model_id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class , 'model_colors',
            'model_id',
            'color_id');
    }

    public function optionals()
    {
        return $this->belongsToMany(Optional::class, 'optional_compatibilities',
            'model_id',
            'optional_id');
    }

    public function accessories()
    {
        return $this->belongsToMany(Accessory::class ,'model_accessory_compatibilities',
            'model_id',
            'accessory_id');
    }

    public function configurations()
    {
        return $this->hasMany(Configuration::class, 'model_id');
    }
}
