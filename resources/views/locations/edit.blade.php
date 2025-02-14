@extends('layouts.app')

@section('content')
  <div class="md:w-[90vw] mt-5 lg:w-2/3 w-full px-6 py-6 mx-auto">
    <!-- table 1 -->
    <div class="card bg-base-100 shadow-xl">
      <div class="p-6 flex pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold text-lg flex-auto">Update Location</h6>
      </div>
      <div class="flex-auto p-5">
        <form role="form" method="POST" class="p-4" action="{{ route('locations.update', encrypt($location->id)) }}">
            @csrf
            @method('PUT')
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                  <div class="label">
                    <span class="label-text">Nama</span>
                  </div>
                    <input type="text"
                    value="{{$location->name}}"
                    name="name" placeholder="Nama" class="input input-bordered input-primary w-full">
                    @error('name')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                  <div class="label">
                    <span class="label-text">City</span>
                  </div>
                    <input type="text"
                    value="{{$location->city}}"
                    name="city" placeholder="City" class="input input-bordered input-primary w-full">
                    @error('city')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                  <div class="label">
                    <span class="label-text">District</span>
                  </div>
                    <input type="text"
                    name="district"
                    placeholder="District"
                    value="{{$location->district}}"
                    class="input input-bordered input-primary w-full">
                    @error('district')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control">
                  <div class="label">
                    <span class="label-text font-bold">Description</span>
                  </div>
                  <textarea class="textarea textarea-bordered h-24"
                    value="{{$location->description}}"
                  placeholder="Description" name="description"></textarea>
                </label>
                @error('description')
                    <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-between px-3">
                <button type="submit" class="btn btn-sm btn-primary">
                    Simpan
                </button>
                <a class="btn btn-sm" href="{{route('locations.index')}}">Kembali</a>
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
