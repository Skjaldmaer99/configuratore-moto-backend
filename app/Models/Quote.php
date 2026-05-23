<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'configuration_id',
        'final_price',
        'pdf_path'
    ];

    public function configuration()
    {
        return $this->belongsTo(Configuration::class);
    }
}
