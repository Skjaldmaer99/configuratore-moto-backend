<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelAccessoryCompatibility extends Model
{
    protected $table = 'model_accessory_compatibility';

    protected $fillable = [
        'model_id',
        'accessory_id'
    ];
}
