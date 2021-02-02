<?php

namespace App\Http\Repositories;

use App\Models\InvoiceLine;
use Illuminate\Support\Facades\DB;

class InvoiceRepository
{
    public function getFullInvoiceInfo()
    {
        //get invoice info
        $invoice_info = InvoiceLine::query();

        //check for location filtering
        if(request()->has('location'))
        {
            $invoice_info->whereHas('invoice_header.location', function ($query){
                $query->where('id', request()->get('location'));
            });
        }

        //check for status filtering
        if(request()->has('status'))
        {
            $invoice_info->whereHas('invoice_header', function ($query){
                $query->where('status', request()->get('status'));
            });
        }

        //check for start-end date filtering
        if(request()->has('end_date') && request()->has('start_date') )
        {
            $invoice_info->whereHas('invoice_header', function ($query){
                $query->whereBetween('date', [request()->get('start_date'), request()->get('end_date')]);
            });
        }

        $invoice_info->select('value', 'invoice_header_id')
            ->with('invoice_header', 'invoice_header.location')
            ->get();

        return $invoice_info;
    }

    public function getInvoicesByLocation()
    {
        //get invoice info
        $invoice_info = InvoiceLine::join('invoice_headers', 'invoice_headers.id', '=', 'invoice_lines.invoice_header_id')
            ->select('status', DB::raw('SUM(value) as value'))
            ->groupBy('invoice_headers.status');

        //check for location filtering
        if(request()->has('location'))
        {
            $invoice_info->join('locations', function($join)
            {
                $join->on('invoice_headers.location_id', '=', 'locations.id');
                $join->where('locations.id','=', request()->get('location'));
            });
        }

        return $invoice_info->get();
    }

}
