<?php


namespace App\Http\Repositories;

use App\Models\Location;

class LocationRepository
{
    public function getAll()
    {
        return Location::get();
    }
}
