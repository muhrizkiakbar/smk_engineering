@extends('layouts.app')

@section('content')
  <div class="md:w-[90vw] mt-5 lg:w-2/3 w-full px-6 py-6 mx-auto">
    <!-- table 1 -->
    <div class="card bg-base-100 shadow-xl">
      <div class="p-6 flex pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold text-lg flex-auto">Update Telemetry</h6>
      </div>
      <div class="flex-auto p-5">
        <form role="form" method="POST" class="p-4" action="{{ route('telemetries.update', encrypt($telemetry->id)) }}">
            @csrf
            @method('PUT')
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">PH</span>
                    </div>
                    <input type="text"
                        value="{{ old('ph', request('ph', $telemetry->ph)) }}"
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
                        value="{{ old('tds', request('tds', $telemetry->tds)) }}"
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
                        value="{{ old('tss', request('tss', $telemetry->tss)) }}"
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
                        <span class="label-text">Velocity</span>
                    </div>
                    <input type="text"
                        value="{{ old('velocity', request('velocity', $telemetry->velocity)) }}"
                        name="velocity"
                        placeholder="Velocity"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('velocity')
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
                        value="{{ old('water_height', request('water_height', $telemetry->water_height)) }}"
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
                        value="{{ old('rainfall', request('rainfall', $telemetry->rainfall)) }}"
                        name="rainfall"
                        placeholder="Rainfall"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('rainfall')
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
    <script src={{asset("assets/js/library.js")}}></script>
    <script>
    </script>
@endpush
