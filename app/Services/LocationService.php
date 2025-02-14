<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Repositories\Locations;
use App\Services\AppService;
use Exception;

class LocationService extends AppService
{
    protected $locationRepository;

    public function __construct()
    {
        $this->locationRepository = new Locations();
    }

    public function locations(Request $request)
    {
        $locations = $this->locationRepository->filter($request->all());
        return $locations;
    }

    public function create(Request $request)
    {
        $location = Location::create($request->all());

        return $location;
    }

    public function update(Location $location, $request)
    {
        // Example logic for updating a photo record
        try {
            $location->update($request->all());

            return $location;
        } catch (Exception $e) {
            throw new Exception('Something went wrong.');
        }
    }

    public function delete(Location $location)
    {
        // Example logic for deleting a photo record
        if ($location->state == "active") {
            $location->state = "archived";
        } else {
            $location->state = "active";
        }

        $location->save();

        return $location;
    }
}
