<?php


namespace App\Http\Repositories;

use App\Models\InvoiceHeader;

class InvoiceHeaderRepository
{
    public function getStatuses()
    {
       return InvoiceHeader::select('status')->distinct()->get();
    }
}
