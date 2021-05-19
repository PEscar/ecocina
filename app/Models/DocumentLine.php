<?php

namespace App\Models;

use App\Models\Document;
use App\Models\GlobalModel;
use App\Models\PurchaseDeliveryNote;

abstract class DocumentLine extends GlobalModel
{
    protected $headerModel = '';

    // RELATIONS
    public function header()
    {
        return $this->belongsTo($this->headerModel, 'header_id');
    }
}