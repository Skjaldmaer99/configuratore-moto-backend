<?php

// app/Models/Configuration.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
        'user_id',
        'model_id',
        'engine_variant_id',
        'color_id',
        'total_price',
        'current_step',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model()
    {
        return $this->belongsTo(Modello::class, 'model_id');
    }

    public function engine()
    {
        return $this->belongsTo(Engine::class, 'engine_variant_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function optionals()
    {
        return $this->belongsToMany(
            Optional::class,
            'configuration_optionals',
            'configuration_id',
            'optional_id'
        );
    }

    public function accessories()
    {
        return $this->belongsToMany(
            Accessory::class,
            'configuration_accessories',
            'configuration_id',
            'accessory_id'
        );
    }

    public function quote()
    {
        return $this->hasOne(Quote::class);
    }
}