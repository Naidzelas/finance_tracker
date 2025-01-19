<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingRequest extends Model
{
    public $fillable = [
        'code',
        'request'
    ];
}
