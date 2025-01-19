<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingRequest extends Model
{
    public $fillable = [
        'code',
        'request'
    ];
}
