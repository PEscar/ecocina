<?php

namespace App\Models;

use App\Models\Document;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Relations\Pivot;

abstract class DocumentLine extends Pivot
{
    protected $headerModel = '';
    public $incrementing = true;

    // RELATIONS
    public function header()
    {
        return $this->belongsTo($this->headerModel, 'header_id');
    }

    // END RELATRIONS
}