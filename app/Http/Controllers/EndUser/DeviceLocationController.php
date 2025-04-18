<?php

namespace App\Http\Controllers\EndUser;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Models\DeviceLocation;
use App\Services\DeviceLocationService;
use App\Services\TelemetryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DevicePhoto;
use App\Services\DevicePhotoService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeviceLocationController extends Controller
{
    protected $telemetryService;
    protected $deviceLocationService;
    protected $devicePhotoService;

    public function __construct()
    {
        $this->telemetryService = new TelemetryService(Auth::user());
        $this->deviceLocationService = new DeviceLocationService(Auth::user());
        $this->devicePhotoService = new DevicePhotoService(Auth::user());
    }

    //
    public function index(Request $request)
    {
        $request_input = $request->merge(
            ['state' => 'active']
        );
        $device_locations =
            DeviceLocation::leftJoin('devices', 'device_locations.device_id', 'devices.id')
                ->leftJoin('locations', 'device_locations.location_id', 'locations.id')
                ->select(
                    'device_locations.*',
                    'devices.name as device_name',
                    'devices.type as device_type',
                    'devices.has_ph',
                    'devices.has_tds',
                    'devices.has_tss',
                    'devices.has_debit',
                    'devices.has_water_height',
                    'devices.has_rainfall',
                    'devices.has_temperature',
                    'devices.has_humidity',
                    'devices.has_wind_direction',
                    'devices.has_wind_speed',
                    'devices.has_solar_radiation',
                    'devices.has_evaporation',
                    'devices.has_dissolve_oxygen',
                    'locations.name as location_name',
                    'locations.city',
                    'locations.district'
                )->where('device_locations.state', 'active');
        if (Auth::user()->department->visibility_telemetry == 'public') {
            $device_locations = $device_locations->get();
        } elseif (Auth::user()->department->visibility_telemetry == 'private') {
            $device_locations = $device_locations->where('department_id', Auth::user()->department->id)->get();
        }

        return view('end_user.device_locations.index', ['device_locations' => $device_locations]);
    }

    public function telemetry(Request $request, string $id)
    {
        $request_input = $request->merge(
            [
                'device_location_id' => $id,
                'LTE_Tanggal' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        );
        $telemetries_query = $this->telemetryService->telemetries($request_input, ['device_location' => ['device', 'location']]);
        $telemetry = $telemetries_query->orderby('created_at', 'desc')->first();
        $telemetries = $telemetries_query->limit(12)->get();
        $device_photo = DevicePhoto::where('state', 'active')->where('device_location_id', $id)->orderby('created_at', 'desc')->first();

        $device_locations =
            DeviceLocation::leftJoin('devices', 'device_locations.device_id', 'devices.id')
                ->leftJoin('locations', 'device_locations.location_id', 'locations.id')
                ->select(
                    'device_locations.*',
                    'devices.name as device_name',
                    'devices.type as device_type',
                    'devices.has_ph',
                    'devices.has_tds',
                    'devices.has_tss',
                    'devices.has_debit',
                    'devices.has_water_height',
                    'devices.has_rainfall',
                    'devices.has_temperature',
                    'devices.has_humidity',
                    'devices.has_wind_direction',
                    'devices.has_wind_speed',
                    'devices.has_solar_radiation',
                    'devices.has_evaporation',
                    'devices.has_dissolve_oxygen',
                    'locations.name as location_name',
                    'locations.city',
                    'locations.district'
                )->where('device_locations.state', 'active');

        if (Auth::user()->department->visibility_telemetry == 'public') {
            $device_locations = $device_locations->get();
        } elseif (Auth::user()->department->visibility_telemetry == 'private') {
            $device_locations = $device_locations->where('department_id', Auth::user()->department->id)->get();
        }

        $current_device_location = DeviceLocation::find($id);

        return view(
            'end_user.device_locations.telemetry',
            [
                'telemetry' => $telemetry,
                'telemetries' => $telemetries,
                'device_photo' => $device_photo,
                'device_locations' => $device_locations,
                'current_device_location' => $current_device_location
            ]
        );
    }


    public function telemetry_json(string $device_location_id)
    {
        $device_location_id = decrypt($device_location_id);
        $request = new Request();
        $request_input = $request->merge(
            [
                'device_location_id' => $device_location_id,
                'LTE_Tanggal' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        );
        $telemetries_query = $this->telemetryService->telemetries($request_input, ['device_location' => ['device', 'location']]);
        $telemetry = $telemetries_query->orderby('created_at', 'desc')->first();
        $telemetries = $telemetries_query->limit(12)->get();
        $device_photo = DevicePhoto::where('device_location_id', $device_location_id)->where('state', 'active')->orderby('created_at', 'desc')->first();

        $lostData = [
            'device_location_id' => $device_location_id,
            'ph' => 0,
            'tds' => 0,
            'tss' => 0,
            'debit' => 0,
            'rainfall' => 0,
            'water_height' => 0,
            'temperature' => 0,
            'humidity' => 0,
            'wind_direction' => 0,
            'wind_speed' => 0,
            'solar_radiation' => 0,
            'evaporation' => 0,
            'dissolve_oxygen' => 0,
        ];

        $fixed_telemetries = [];
        $last_created_at = null;
        $current_index = 0;
        foreach ($telemetries as $key => $telemetri) {
            if ($key == 0) {
                $last_created_at = $telemetri->created_at;
                array_push($fixed_telemetries, $telemetri);
            } else {
                $last = Carbon::parse($last_created_at);
                $current = Carbon::parse($telemetri->created_at);
                $diffInMinutes = $current->diffInMinutes($last);

                //if ($diffInMinutes > 110) {
                //    $new_last_temp = $last->addMinutes(55)->subHours(1);
                //    $lostData['created_at'] = $new_last_temp;
                //    $lostData['updated_at'] = $new_last_temp;
                //    array_push($fixed_telemetries, $lostData);
                //    array_push($fixed_telemetries, $telemetri);
                //} else {
                //}
                array_push($fixed_telemetries, $telemetri);
            }
            $current_index = $current_index + 1;
            $last_created_at = $telemetri->created_at;
        }

        return response()->json([
            'ph' => $telemetry->ph,
            'tds' => $telemetry->tds,
            'tss' => $telemetry->tss,
            'debit' => $telemetry->debit,
            'rainfall' => $telemetry->rainfall,
            'water_height' => $telemetry->water_height,
            'temperature' => $telemetry->temperature,
            'humidity' => $telemetry->humidity,
            'wind_direction' => $telemetry->wind_direction,
            'wind_speed' => $telemetry->wind_speed,
            'solar_radiation' => $telemetry->solar_radiation,
            'evaporation' => $telemetry->evaporation,
            'dissolve_oxygen' => $telemetry->dissolve_oxygen,
            'device_photo' => $device_photo != null ? $device_photo->photo : null,
            'telemetries' => $fixed_telemetries,
        ]);
    }

    public function device_photos(Request $request, string $device_location_id)
    {
        $request_input = $request->merge(
            [
                'device_location_id' => $device_location_id,
                'state' => 'active'
            ]
        );

        $device_locations =
            DeviceLocation::leftJoin('devices', 'device_locations.device_id', 'devices.id')
                ->leftJoin('locations', 'device_locations.location_id', 'locations.id')
                ->select(
                    'device_locations.*',
                    'devices.name as device_name',
                    'devices.type as device_type',
                    'devices.has_ph',
                    'devices.has_tds',
                    'devices.has_tss',
                    'devices.has_debit',
                    'devices.has_water_height',
                    'devices.has_rainfall',
                    'devices.has_temperature',
                    'devices.has_humidity',
                    'devices.has_wind_direction',
                    'devices.has_wind_speed',
                    'devices.has_solar_radiation',
                    'devices.has_evaporation',
                    'devices.has_dissolve_oxygen',
                    'locations.name as location_name',
                    'locations.city',
                    'locations.district'
                )->where('device_locations.state', 'active');
        if (Auth::user()->department->visibility_telemetry == 'public') {
            $device_locations = $device_locations->get();
        } elseif (Auth::user()->department->visibility_telemetry == 'private') {
            $device_locations = $device_locations->where('department_id', Auth::user()->department->id)->get();
        }

        $device_location = DeviceLocation::find($device_location_id);
        $device_photos = DevicePhoto::where('device_location_id', $device_location_id)->where('state', 'active')->orderBy('created_at', 'desc')->cursorPaginate(10)->withQueryString();
        $device_photo = DevicePhoto::where('state', 'active')->where('device_location_id', $device_location_id)->orderby('created_at', 'desc')->first();
        return view(
            'end_user.device_locations.device_photo',
            [
                'device_photos' => $device_photos,
                'device_photo' => $device_photo,
                'device_location' => $device_location,
                'device_locations' => $device_locations
            ]
        );
    }

    public function create_device_photo(string $device_location_id)
    {
        $device = $this->devicePhotoService->request_create($device_location_id);
        return redirect(route('enduser.device_locations.telemetry', ['id' => $device_location_id]))->with('status', 'Request for photo of device was created');
    }

    public function download($id, $device_photo_id)
    {
        $photo = DevicePhoto::findOrFail(decrypt($device_photo_id));
        $url = $photo->photo; // URL ke file MinIO

        // Ambil ekstensi asli dari URL
        $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        $filename = Str::slug(
            $photo->device_location->device->name . '-' . $photo->device_location->location->name . '-' . $photo->created_at->format('Ymd_His')
        ) . '.' . $extension;


        // Ambil isi file
        $fileContents = file_get_contents($url);

        // Deteksi MIME type (optional tapi bagus)
        $mimeType = \Illuminate\Support\Facades\Http::head($url)->header('Content-Type') ?? 'application/octet-stream';

        return response($fileContents)
            ->header('Content-Type', 'image/jpeg')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    public function telemetry_sensor(Request $request)
    {
        $device_locations = DeviceLocation::with(['device', 'location'])->where('state', 'active')->orderby('id', 'asc');

        if (Auth::user()->department->visibility_telemetry == 'public') {
            $device_locations = $device_locations->get();
        } elseif (Auth::user()->department->visibility_telemetry == 'private') {
            $device_locations = $device_locations->where('department_id', Auth::user()->department->id)->get();
        }

        $telemetries = DB::table(DB::raw(
            "
                (SELECT telemetries.*,
                        devices.name AS device_name,
                        locations.name AS location_name,
                        ROW_NUMBER() OVER (PARTITION BY telemetries.device_location_id ORDER BY telemetries.created_at DESC) AS row_num
                FROM telemetries
                LEFT JOIN device_locations ON telemetries.device_location_id = device_locations.id
                LEFT JOIN devices ON device_locations.device_id = devices.id
                LEFT JOIN locations ON device_locations.location_id = locations.id
                WHERE telemetries.device_location_id IN (" . $device_locations->pluck('id')->implode(',') . ")
                AND telemetries.created_at <= '" . Carbon::now() . "'
                ) AS t
                "
        ))
            ->where('row_num', '<=', 12)
            ->orderBy('t.created_at', 'desc')
            ->get()
            ->groupBy('device_location_id');

        return view(
            'end_user.device_locations.sensor',
            [
                'telemetries' => $telemetries,
            ]
        );
    }

    public function telemetry_sensor_json(Request $request)
    {
        $device_locations = DeviceLocation::with(['device', 'location'])->where('state', 'active')->orderby('id', 'asc');

        if (Auth::user()->department->visibility_telemetry == 'public') {
            $device_locations = $device_locations->get();
        } elseif (Auth::user()->department->visibility_telemetry == 'private') {
            $device_locations = $device_locations->where('department_id', Auth::user()->department->id)->get();
        }

        $telemetries = DB::table(DB::raw(
            "
                (SELECT telemetries.*,
                        devices.name AS device_name,
                        locations.name AS location_name,
                        ROW_NUMBER() OVER (PARTITION BY telemetries.device_location_id ORDER BY telemetries.created_at DESC) AS row_num
                FROM telemetries
                LEFT JOIN device_locations ON telemetries.device_location_id = device_locations.id
                LEFT JOIN devices ON device_locations.device_id = devices.id
                LEFT JOIN locations ON device_locations.location_id = locations.id
                WHERE telemetries.device_location_id IN (" . $device_locations->pluck('id')->implode(',') . ")
                AND telemetries.created_at <= '" . Carbon::now() . "'
                ) AS t
                "
        ))
            ->where('row_num', '<=', 12)
            ->orderBy('t.created_at', 'desc')
            ->get()
            ->groupBy('device_location_id');

        return response()->json($telemetries);
    }
}
