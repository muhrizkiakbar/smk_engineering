@extends('layouts.app')

@section('content')
  <div class="md:w-[90vw] mt-5 lg:w-2/3 w-full px-6 py-6 mx-auto">
    <!-- table 1 -->
    <div class="card bg-base-100 shadow-xl">
      <div class="p-6 flex pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold text-lg flex-auto">Add Device Location</h6>
      </div>
      <div class="flex-auto p-5">
        <form role="form" method="POST" class="p-4" action="{{ route('device_locations.store') }}">
            @csrf
            @method('POST')
            <div class="mb-4 px-3">
                <label for="from" class="label">Device</label>
                <select class="select select-bordered w-full" name="device_id">
                    @foreach($devices as $device)
                        <option value="{{$device->id}}"
                            @selected(
                            old('device_id') == $device->id
                            )
                        >{{$device->name.' ',$device->type}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4 px-3">
                <label for="from" class="label">Department</label>
                <select class="select select-bordered w-full" name="department_id">
                    @foreach($departments as $department)
                        <option value="{{$department->id}}"
                            @selected(
                            old('department_id') == $department->id
                            )
                        >{{$department->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4 px-3">
                <label for="from" class="label">Location</label>
                <select class="select select-bordered w-full" name="location_id">
                    @foreach($locations as $location)
                        <option value="{{$location->id}}"
                            @selected(
                                old('location_id') == $location->id
                            )
                        >{{$location->name.' - '.$location->city.' - '.$location->district}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Longitude</span>
                    </div>
                    <input type="text"
                        value="{{ old('longitude', request('longitude')) }}"
                        name="longitude"
                        placeholder="Longitude"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('longitude')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Latitude</span>
                    </div>
                    <input type="text"
                        value="{{ old('latitude', request('latitude')) }}"
                        name="latitude"
                        placeholder="Latitude"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('latitude')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Formula</span>
                    </div>
                    <input type="text"
                        value="{{ old('formula', request('formula')) }}"
                        name="formula"
                        placeholder="Formula"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('formula')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="flex justify-between px-3">
                <button type="submit" class="btn btn-sm btn-primary">
                    Simpan
                </button>
                <a class="btn btn-sm" href="{{route('device_locations.index')}}">Kembali</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
@endpush
