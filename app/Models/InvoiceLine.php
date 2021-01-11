<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    use HasFactory;

    public function invoice_header()
    {
        return $this->hasOne(InvoiceHeader::class, 'id', 'invoice_header_id');
    }
}
