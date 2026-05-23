<?php

// app/Models/OptionalCompatibility.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelOptionalCompatibility extends Model
{
    protected $table = 'model_optional_compatibility';

    protected $fillable = [
        'model_id',
        'optional_id'
    ];
}
