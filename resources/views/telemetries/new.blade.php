@extends('layouts.app')

@section('content')
  <div class="md:w-[90vw] mt-5 lg:w-2/3 w-full px-6 py-6 mx-auto">
    <!-- table 1 -->
    <div class="card bg-base-100 shadow-xl">
      <div class="p-6 flex pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold text-lg flex-auto">Add Telemetry</h6>
      </div>
      <div class="flex-auto p-5">
        <form role="form" method="POST" class="p-4" action="{{ route('telemetries.store') }}">
            @csrf
            @method('POST')
            <div class="mb-4 px-3">
                <label for="from" class="label">Device Location</label>
                <select class="select select-bordered w-full" name="device_location_id">
                    <option value=""
                        @selected(
                            request('device_location_id') == ""
                        )
                    >Pilih Device</option>
                    @foreach($device_locations as $device_location)
                        <option value="{{$device_location->id}}"
                            @selected(
                                old('device_location_id', request('device_location_id')) == $device_location->id
                            )
                        >
                        {{
                            $device_location->device->name.' @ '.
                            $device_location->location->name.' '.
                            $device_location->location->city.' - '.
                            $device_location->location->district

                        }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Date and Time</span>
                    </div>
                    <div class="inline-flex items-center relative">
                        <a href="#" class="btn btn-ghost btn-sm clear_bought_at btn-circle absolute right-0 mr-2">
                            <i class="fa-solid fa-times text-lg"></i>
                        </a>

                        <input type="text"
                            value="{{ old('created_at', request('created_at')) }}"
                            name="created_at"
                            class="input input-bordered input-date input-primary w-full"
                        >
                    </div>
                    @error('created_at')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">PH</span>
                    </div>
                    <input type="text"
                        value="{{ old('ph', request('ph')) }}"
                        name="ph"
                        placeholder="PH"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('ph')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">TDS</span>
                    </div>
                    <input type="text"
                        value="{{ old('tds', request('tds')) }}"
                        name="tds"
                        placeholder="TDS"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('tds')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">TSS</span>
                    </div>
                    <input type="text"
                        value="{{ old('tss', request('tss')) }}"
                        name="tss"
                        placeholder="TSS"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('tss')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Debit</span>
                    </div>
                    <input type="text"
                        value="{{ old('debit', request('debit')) }}"
                        name="debit"
                        placeholder="Debit"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('debit')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Water Height</span>
                    </div>
                    <input type="text"
                        value="{{ old('water_height', request('water_height')) }}"
                        name="water_height"
                        placeholder="Water Height"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('water_height')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Rainfall</span>
                    </div>
                    <input type="text"
                        value="{{ old('rainfall', request('rainfall')) }}"
                        name="rainfall"
                        placeholder="Rainfall"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('rainfall')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Temperature</span>
                    </div>
                    <input type="text"
                        value="{{ old('temperature', request('temperature')) }}"
                        name="temperature"
                        placeholder="Temperature"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('temperature')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Humidity</span>
                    </div>
                    <input type="text"
                        value="{{ old('humidity', request('humidity')) }}"
                        name="humidity"
                        placeholder="Humidity"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('humidity')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Wind Direction</span>
                    </div>
                    <input type="text"
                        value="{{ old('wind_direction', request('wind_direction')) }}"
                        name="wind_direction"
                        placeholder="Wind Direction"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('wind_direction')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Wind Speed</span>
                    </div>
                    <input type="text"
                        value="{{ old('wind_speed', request('wind_speed')) }}"
                        name="wind_speed"
                        placeholder="Wind Speed"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('wind_speed')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Solar Radiation</span>
                    </div>
                    <input type="text"
                        value="{{ old('solar_radiation', request('solar_radiation')) }}"
                        name="solar_radiation"
                        placeholder="Solar Radiation"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('solar_radiation')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Evaporation</span>
                    </div>
                    <input type="text"
                        value="{{ old('evaporation', request('evaporation')) }}"
                        name="evaporation"
                        placeholder="Evaporation"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('rainfall')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Dissolve Oxygen</span>
                    </div>
                    <input type="text"
                        value="{{ old('evaporation', request('dissolve_oxygen')) }}"
                        name="dissolve_oxygen"
                        placeholder="Dissolve Oxygen"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('dissolve_oxygen')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="flex justify-between px-3">
                <button type="submit" class="btn btn-sm btn-primary">
                    Simpan
                </button>
                <a class="btn btn-sm" href="{{route('telemetries.index')}}">Kembali</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
@endpush
