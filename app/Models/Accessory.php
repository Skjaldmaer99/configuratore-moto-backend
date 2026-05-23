<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Accessory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'category'
    ];

    public function models()
    {
        return $this->belongsToMany(
            Modello::class,
            'model_accessory_compatibilities',
            'accessory_id',
            'model_id'
        );
    }

    public function configurations()
    {
        return $this->belongsToMany(
            Configuration::class,
            'configuration_accessories',
            'accessory_id',
            'configuration_id'
        );
    }
}