<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    public $fillable = [
        'documentable_id',
        'documentable_type',
        'filename',
        'file_path'
    ];

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}
