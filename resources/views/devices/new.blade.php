@extends('layouts.app')

@section('content')
  <div class="md:w-[90vw] mt-5 lg:w-2/3 w-full px-6 py-6 mx-auto">
    <!-- table 1 -->
    <div class="card bg-base-100 shadow-xl">
      <div class="p-6 flex pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold text-lg flex-auto">Add Device</h6>
      </div>
      <div class="flex-auto p-5">
        <form role="form" method="POST" class="p-4" action="{{ route('devices.store') }}">
            @csrf
            @method('POST')
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Name</span>
                    </div>
                    <input type="text"
                        value="{{ old('name', request('name')) }}"
                        name="name"
                        placeholder="Name"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('name')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Phone Number</span>
                    </div>
                    <input type="text"
                        value="{{ old('phone_number', request('phone_number')) }}"
                        name="phone_number"
                        placeholder="Phone Number"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('phone_number')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                  <div class="label">
                    <span class="label-text">Type</span>
                  </div>
                    <select class="select select-bordered w-full" name="type">
                        @foreach(["RTU", "Raspberry"] as $type)
                            <option value="{{$type}}"
                                @selected(old('type') == $type)
                            >{{$type}}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Bought At</span>
                    </div>
                    <div class="inline-flex items-center relative">
                        <a href="#" class="btn btn-ghost btn-sm clear_bought_at btn-circle absolute right-0 mr-2">
                            <i class="fa-solid fa-times text-lg"></i>
                        </a>

                        <input type="text"
                            value="{{ old('bought_at', request('bought_at')) }}"
                            name="bought_at"
                            class="input input-bordered input-date input-primary w-full"
                        >
                    </div>
                    @error('bought_at')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Used At</span>
                    </div>
                    <div class="inline-flex items-center relative">
                        <a href="#" class="btn btn-ghost btn-sm clear_used_at btn-circle absolute right-0 mr-2">
                            <i class="fa-solid fa-times text-lg"></i>
                        </a>

                        <input type="text"
                            value="{{ old('used_at', request('used_at')) }}"
                            name="used_at"
                            class="input input-bordered input-date input-primary w-full"
                        >
                    </div>
                    @error('used_at')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <div class="flex flex-row">
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_ph" value="0">
                            <input type="checkbox" name="has_ph" value="1" class="toggle toggle-primary"
                                @if (old('has_ph', request('has_ph')) == "1")
                                    checked="checked"
                                @endif
                            />
                            <span class="label-text ps-5">PH</span>
                            @error('has_ph')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_tds" value="0">
                            <input type="checkbox" name="has_tds" value="1" class="toggle toggle-primary"
                                @if (old('has_tds', request('has_tds')) == "1")
                                    checked="checked"
                                @endif
                            />
                            <span class="label-text ps-5">TDS</span>
                            @error('has_tds')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_tss" value="0">
                            <input type="checkbox" name="has_tss" value="1" class="toggle toggle-primary"
                                @if (old('has_tss', request('has_tss')) == "1")
                                    checked="checked"
                                @endif
                            />
                            <span class="label-text ps-5">TSS</span>
                            @error('has_tss')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_velocity" value="0">
                            <input type="checkbox" name="has_velocity" value="1" class="toggle toggle-primary"
                                @if (old('has_velocity', request('has_velocity')) == "1")
                                    checked="checked"
                                @endif
                            />
                            <span class="label-text ps-5">Velocity</span>
                            @error('has_velocity')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_rainfall" value="0">
                            <input type="checkbox" name="has_rainfall" value="1" class="toggle toggle-primary"
                            @if (old('has_rainfall', request('has_rainfall')) == "1")
                                checked="checked"
                            @endif
                            />
                            <span class="label-text ps-5">Rainfall</span>
                            @error('has_rainfall')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_water_height" value="0">
                            <input type="checkbox" name="has_water_height" value="1" class="toggle toggle-primary"
                                @if (old('has_water_height', request('has_water_height')) == "1")
                                    checked="checked"
                                @endif
                            />
                            <span class="label-text ps-5">Water Level</span>
                            @error('has_water_height')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                </div>
            </div>
            <div class="mb-4 px-3">
                <div class="flex flex-row">
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_temperature" value="0">
                            <input type="checkbox" name="has_temperature" value="1" class="toggle toggle-primary"
                                @if (old('has_temperature', request('has_temperature')) == "1")
                                    checked="checked"
                                @endif
                            />
                            <span class="label-text ps-5">Temperature</span>
                            @error('has_temperature')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_humidity" value="0">
                            <input type="checkbox" name="has_humidity" value="1" class="toggle toggle-primary"
                            @if (old('has_humidity', request('has_humidity')) == "1")
                                checked="checked"
                            @endif
                            />
                            <span class="label-text ps-5">Humidity</span>
                            @error('has_humidity')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_wind_direction" value="0">
                            <input type="checkbox" name="has_wind_direction" value="1" class="toggle toggle-primary"
                                @if (old('has_wind_direction', request('has_wind_direction')) == "1")
                                    checked="checked"
                                @endif
                            />
                            <span class="label-text ps-5">Wind Direction</span>
                            @error('has_wind_direction')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_wind_speed" value="0">
                            <input type="checkbox" name="has_wind_speed" value="1" class="toggle toggle-primary"
                                @if (old('has_wind_speed', request('has_wind_speed')) == "1")
                                    checked="checked"
                                @endif
                            />
                            <span class="label-text ps-5">Wind Speed</span>
                            @error('has_wind_speed')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_solar_radiation" value="0">
                            <input type="checkbox" name="has_solar_radiation" value="1" class="toggle toggle-primary"
                                @if (old('has_solar_radiation', request('has_solar_radiation')) == "1")
                                    checked="checked"
                                @endif
                            />
                            <span class="label-text ps-5">Solar Radiation</span>
                            @error('has_solar_radiation')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_evaporation" value="0">
                            <input type="checkbox" name="has_evaporation" value="1" class="toggle toggle-primary"
                                @if (old('has_evaporation', request('has_evaporation')) == "1")
                                    checked="checked"
                                @endif
                            />
                            <span class="label-text ps-5">Evaporation</span>
                            @error('has_evaporation')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control w-52 items-start">
                        <label class="label cursor-pointer">
                            <input type="hidden" name="has_dissolve_oxygen" value="0">
                            <input type="checkbox" name="has_dissolve_oxygen" value="1" class="toggle toggle-primary"
                                @if (old('has_dissolve_oxygen', request('has_dissolve_oxygen')) == "1")
                                    checked="checked"
                                @endif
                            />
                            <span class="label-text ps-5">Dissolve Oxygen</span>
                            @error('has_dissolve_oxygen')
                                <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex justify-between px-3">
                <button type="submit" class="btn btn-sm btn-primary">
                    Simpan
                </button>
                <a class="btn btn-sm" href="{{route('devices.index')}}">Kembali</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
@endpush
