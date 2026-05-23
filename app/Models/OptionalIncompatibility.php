<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionalIncompatibility extends Model
{
    protected $table = 'optional_incompatibilities';

    protected $fillable = [
        'optional_1_id',
        'optional_2_id'
    ];
}