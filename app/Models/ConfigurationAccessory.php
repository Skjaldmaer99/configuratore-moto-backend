<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigurationAccessory extends Model
{
    protected $fillable = [
        'configuration_id',
        'accessory_id'
    ];
}
