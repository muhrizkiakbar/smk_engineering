<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    //
    protected $locationService;

    public function __construct()
    {
        $this->locationService = new LocationService(Auth::user());
    }

    //
    public function index(Request $request)
    {
        $locations = $this->locationService->locations($request)->cursorPaginate(10)->withQueryString();

        return view('locations.index', ['locations' => $locations]);
    }

    public function create()
    {
        return view('locations.new');
    }

    public function store(LocationRequest $request)
    {
        $this->locationService->create($request);
        return redirect("locations")->with('status', 'Lokasi telah dibuat');
    }

    public function edit(string $id)
    {
        $location = Location::find(decrypt($id));
        return view('locations.edit', ['location' => $location]);
    }

    public function update(LocationRequest $request, string $id)
    {
        $location = Location::find(decrypt($id));
        $location = $this->locationService->update($location, $request);

        return redirect("locations")->with('status', 'Saldo Berhasil Diubah');
    }

    public function destroy(string $id)
    {
        $location = Location::find(decrypt($id));
        $location = $this->locationService->delete($location);

        if ($location->state == "active") {
            $message = "Lokasi berhasil diaktifkan.";
        } else {
            $message = "Lokasi berhasil dinonaktifkan.";
        }

        return redirect("locations")->with('status', $message);
    }
}
