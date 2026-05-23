<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Optional extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'type'
    ];

    public function models()
    {
        return $this->belongsToMany(
            Modello::class,
            'optional_compatibilities',
            'optional_id',
            'model_id'
        );
    }

    public function configurations()
    {
        return $this->belongsToMany(
            Configuration::class,
            'configuration_optionals',
            'optional_id',
            'configuration_id'
        );
    }

    public function incompatibleOptionals()
    {
        return $this->belongsToMany(
            Optional::class,
            'optional_incompatibilities',
            'optional_1_id',
            'optional_2_id'
        );
    }
}
