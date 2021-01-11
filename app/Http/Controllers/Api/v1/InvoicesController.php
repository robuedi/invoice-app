<?php


namespace App\Http\Controllers\Api\v1;


use App\Http\Resources\StatusResource;
use App\Models\InvoiceHeader;
use App\Models\InvoiceLine;
use Illuminate\Http\Request;
use App\Http\Resources\FullInvoiceCollectionResource;

class InvoicesController
{
    public function index(Request $request) : FullInvoiceCollectionResource
    {
        //get invoice info
        $invoice_info = InvoiceLine::query();

        //check for location filtering
        if($request->has('location'))
        {
            $invoice_info->whereHas('invoice_header.location', function ($query) use ($request){
                $query->where('id', $request->get('location'));
            });
        }

        //check for status filtering
        if($request->has('status'))
        {
            $invoice_info->whereHas('invoice_header', function ($query) use ($request){
                $query->where('status', $request->get('status'));
            });
        }

        //check for start-end date filtering
        if($request->has('end_date') && $request->has('start_date') )
        {
            $invoice_info->whereHas('invoice_header', function ($query) use ($request){
                $query->whereBetween('date', [$request->get('start_date'), $request->get('end_date')]);
            });
        }

        return new FullInvoiceCollectionResource($invoice_info->with('invoice_header', 'invoice_header.location')->get());
    }

    public function invoicesByLocation()
    {

    }

    public function invoicesStatuses() : StatusResource
    {
        $statuses = InvoiceHeader::select('status')->distinct()->get();

        return new StatusResource($statuses);
    }

}
