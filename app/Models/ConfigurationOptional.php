<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigurationOptional extends Model
{
    protected $fillable = [
        'configuration_id',
        'optional_id'
    ];
}