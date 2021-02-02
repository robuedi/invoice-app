<?php


namespace App\Http\Controllers\Api\v1;

use App\Http\Repositories\LocationRepository;
use App\Http\Resources\LocationCollectionResource;

class LocationsController
{
    private LocationRepository $location_repository;

    public function __construct(LocationRepository $location_repository)
    {
        $this->location_repository = $location_repository;
    }

    public function index() : LocationCollectionResource
    {
        return new LocationCollectionResource($this->location_repository->get());
    }
}
