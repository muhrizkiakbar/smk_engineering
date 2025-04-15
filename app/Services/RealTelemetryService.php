<?php

namespace App\Services;

use App\Models\RealTelemetry;
use Illuminate\Http\Request;
use App\Repositories\RealTelemetries;
use App\Services\AppService;
use App\Services\TelegramService;
use App\Models\DeviceLocationWarning;
use App\Models\DeviceLocation;
use Exception;

class RealTelemetryService extends AppService
{
    protected $realTelemetryRepository;

    public function __construct()
    {
        $this->realTelemetryRepository = new RealTelemetries();
    }

    public function realtelemetries(Request $request)
    {
        $telemetries = $this->realTelemetryRepository->filter($request->all());
        return $telemetries;
    }

    public function create($request)
    {
        $telemetry = RealTelemetry::create($request);
        $this->report_telegram($telemetry);

        return $telemetry;
    }

    public function update(RealTelemetry $telemetry, $request)
    {
        try {
            $telemetry->update($request);

            return $telemetry;
        } catch (Exception $e) {
            throw new Exception('Something went wrong.');
        }
    }

    public function delete(RealTelemetry $telemetry)
    {
        $telemetry->delete();
        return $telemetry;
    }

    public function report_telegram($realtelemetry)
    {

        $device_location = DeviceLocation::find($realtelemetry->device_location_id);

        $device_location_warnings =
            DeviceLocationWarning::where('device_location_id', '=', $realtelemetry->device_location_id)
                ->get();
        $device_location_warning_key_by_types = $device_location_warnings->keyBy('type');
        $typeKeys = $device_location_warning_key_by_types->keys();

        $needSendMessage = false;
        $message = '<b>Warning!!</b>';

        foreach ($typeKeys as $typeKey) {
            if (
                ($realtelemetry->{$typeKey} < $device_location_warning_key_by_types[$typeKey]["low_bottom_threshold_start"]) &&
            ) {
                $message .= "\nLokasi Alat : ".$device_location->device->name." - ".$device_location->location->name;
                $message .= "\n".$this->locale_sensor($typeKey)." : <b>".$realtelemetry->{$typeKey}."</b>";
                $message .= "\nNilai sensor ".$this->locale_sensor($typeKey)." berada di batas bawah.";
                $message .= "\n".warning_indicator($realtelemetry, $device_location_warning_key_by_types, $typeKeys, "bottom");

                $needSendMessage = true;
            } elseif (
                ($realtelemetry->{$typeKey} > $device_location_warning_key_by_types[$typeKey]["low_upper_threshold_start"]) &&
            ) {
                $message .= "\nLokasi Alat : ".$device_location->device->name." - ".$device_location->location->name;
                $message .= "\n".$this->locale_sensor($typeKey)." : <b>".$realtelemetry->{$typeKey}."</b>";
                $message .= "\nNilai sensor ".$this->locale_sensor($typeKey)." berada di batas atas.";
                $message .= "\n".warning_indicator($realtelemetry, $device_location_warning_key_by_types, $typeKeys, "upper");

                $needSendMessage = true;
            }
            $message .= "\n";
        }

        if ($needSendMessage) {
            TelegramService::sendMessage($message);
        }
    }


    public function locale_sensor($data)
    {
        if ("ph" == $data) {
            return "PH";
        } elseif ("tds" == $data) {
            return "TDS";
        } elseif ("tss" == $data) {
            return "TSS";
        } elseif ("rainfall" == $data) {
            return "Rainfall";
        } elseif ("water_height" == $data) {
            return "Water Level";
        } elseif ("debit" == $data) {
            return "Debit";
        } elseif ("temperature" == $data) {
            return "Temperature";
        } elseif ("humidity" == $data) {
            return "Humidity";
        } elseif ("wind_direction" == $data) {
            return "Wind Direction";
        } elseif ("wind_speed" == $data) {
            return "Wind Speed";
        } elseif ("solar_radiation" == $data) {
            return "Solar Radiation";
        } elseif ("evaporation" == $data) {
            return "Evaporation";
        } elseif ("dissolve_oxygen" == $data) {
            return "Dissolve Oxygen";
        }
    }

    public function warning_indicator($data, $device_location_warning_key_by_types, $type_key, $upper_or_bottom)
    {
        $type_threshold= $upper_or_bottom == "upper" ? "batas atas" : "batas bawah";
        $message = "Tingkat waspada berada pada ".$type_threshold." dengan level ";
        if (
            ($data->{$type_key} >= $device_location_warning_key_by_types[$type_key]["low_".$upper_or_bottom."_threshold_start"]) &&
            ($data->{$type_key} <= $device_location_warning_key_by_types[$type_key]["low_".$upper_or_bottom."_threshold_end"]) &&
        ){
            $message = $message."rendah";
        } elseif (
            ($data->{$type_key} >= $device_location_warning_key_by_types[$type_key]["middle_".$upper_or_bottom."_threshold_start"]) &&
            ($data->{$type_key} <= $device_location_warning_key_by_types[$type_key]["middle_".$upper_or_bottom."_threshold_end"]) &&
        ){
            $message = $message."menengah";
        } elseif (
            ($data->{$type_key} >= $device_location_warning_key_by_types[$type_key]["high_".$upper_or_bottom."_threshold_start"]) &&
            ($data->{$type_key} <= $device_location_warning_key_by_types[$type_key]["high_".$upper_or_bottom."_threshold_end"]) &&
        ){
            $message = $message."tinggi";
        }

        return $message;
    }
}
