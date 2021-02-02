<?php


namespace App\Http\Controllers\Api\v1;


use App\Http\Repositories\InvoiceHeaderRepository;
use App\Http\Repositories\InvoiceRepository;
use App\Http\Resources\InvoiceSumCollectionResource;
use App\Http\Resources\StatusCollectionResource;
use App\Models\InvoiceHeader;
use Illuminate\Http\Request;
use App\Http\Resources\FullInvoiceCollectionResource;

class InvoicesController
{
    private InvoiceRepository $invoice_line_repository ;
    private InvoiceHeaderRepository $invoice_header_repository ;

    public function __construct(InvoiceRepository $invoice_line_repository, InvoiceHeaderRepository $invoice_header_repository){
        $this->invoice_line_repository = $invoice_line_repository;
        $this->invoice_header_repository = $invoice_header_repository;
    }

    public function index() : FullInvoiceCollectionResource
    {
        return new FullInvoiceCollectionResource($this->invoice_line_repository->getFullInvoiceInfo());
    }

    public function getInvoicesByLocation() : InvoiceSumCollectionResource
    {
        return new InvoiceSumCollectionResource($this->invoice_line_repository->getInvoicesByLocation());
    }

    public function invoicesStatuses() : StatusCollectionResource
    {
        return new StatusCollectionResource($this->invoice_header_repository->getStatuses());
    }

}
