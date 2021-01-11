<?php


namespace App\Http\Controllers\Api\v1;


use App\Http\Resources\LocationCollectionResource;
use App\Models\Location;

class LocationsController
{
    public function index() : LocationCollectionResource
    {
        return new LocationCollectionResource(Location::get());
    }
}
