<?php


namespace App\Http\Controllers\Api\v1;


use App\Http\Resources\InvoiceSumCollectionResource;
use App\Http\Resources\StatusCollectionResource;
use App\Models\InvoiceHeader;
use App\Models\InvoiceLine;
use Illuminate\Http\Request;
use App\Http\Resources\FullInvoiceCollectionResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

        return new FullInvoiceCollectionResource($invoice_info->select('value', 'invoice_header_id')->with('invoice_header', 'invoice_header.location')->get());
    }

    public function getInvoicesByLocation(Request $request) : InvoiceSumCollectionResource
    {
        //get invoice info
        $invoice_info = InvoiceLine::join('invoice_headers', 'invoice_headers.id', '=', 'invoice_lines.invoice_header_id')
            ->select('status', DB::raw('SUM(value) as value'))
            ->groupBy('invoice_headers.status');

        //check for location filtering
        if($request->has('location'))
        {
            $invoice_info->join('locations', function($join) use ($request)
            {
                $join->on('invoice_headers.location_id', '=', 'locations.id');
                $join->where('locations.id','=', $request->get('location'));
            });
        }

        return new InvoiceSumCollectionResource($invoice_info->get());
    }

    public function invoicesStatuses() : StatusCollectionResource
    {
        $statuses = InvoiceHeader::select('status')->distinct()->get();

        return new StatusCollectionResource($statuses);
    }

}
