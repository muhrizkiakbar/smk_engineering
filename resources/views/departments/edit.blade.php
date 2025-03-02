@extends('layouts.app')

@section('content')
  <div class="md:w-[90vw] mt-5 lg:w-2/3 w-full px-6 py-6 mx-auto">
    <!-- table 1 -->
    <div class="card bg-base-100 shadow-xl">
      <div class="p-6 flex pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold text-lg flex-auto">Ubah Device</h6>
      </div>
      <div class="flex-auto p-5">
        <form role="form" method="POST" class="p-4" action="{{ route('devices.update', encrypt($device->id)) }}">
            @csrf
            @method('PUT')
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Name</span>
                    </div>
                    <input type="text"
                        value="{{ old('name', request('name', $department->name)) }}"
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
                    <span class="label-text">Visibility Telemetry</span>
                  </div>
                    <select class="select select-bordered w-full" name="type">
                        @foreach(["public", "private"] as $visibility_telemetry)
                            <option value="{{$visibility_telemetry}}"
                                @selected(old('visibility_telemetry', request('visibility_telemetry', $department->visibility_telemetry)) == $visibility_telemetry)
                            >{{$visibility_telemetry}}</option>
                        @endforeach
                    </select>
                    @error('visibility_telemetry')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="flex justify-between px-3">
                <button type="submit" class="btn btn-sm btn-primary">
                    Simpan
                </button>
                <a class="btn btn-sm" href="{{route('departments.index')}}">Kembali</a>
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
