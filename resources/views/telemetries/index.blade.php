@extends('layouts.app')

@section('search')
    <div class="flex items-center md:ml-auto md:pr-4">
      <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease">
        <span class="text-sm ease leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
          <i class="fas fa-search"></i>
        </span>
        <input type="text" class="pl-9 text-sm focus:shadow-primary-outline ease w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow" placeholder="Type here..." />
      </div>
    </div>
@endsection

@section('content')
    <!-- Open the modal using ID.showModal() method -->
  <dialog id="my_modal_5" class="modal modal-flatpickr modal-bottom sm:modal-middle">
    <div class="modal-box">
      <h3 class="ms-3 mb-4 text-lg font-bold">Cari Data</h3>
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <form role="form" method="GET" action="{{ route('telemetries.index') }}">
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
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
                                request('device_location_id') == $device_location->id
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
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Date At</span>
                        </div>
                        <div class="inline-flex items-center relative">
                            <a href="#" class="btn btn-ghost btn-sm clear_tanggal btn-circle absolute right-0 mr-2">
                                <i class="fa-solid fa-times text-lg"></i>
                            </a>
                            <input type="text"
                                value="{{ old('bought_at', request('tanggal')) }}"
                                name="tanggal"
                                class="input input-bordered input-date-dialog input-primary w-full"
                            >
                        </div>
                        @error('tanggal')
                            <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </label>
                </div>
            </div>
            <div class="flex justify-between px-3">
                <button type="submit" class="btn btn-primary w-full">
                   Cari
                </button>
            </div>
        </form>
    </div>
  </dialog>
  <dialog id="modal_generate" class="modal modal-flatpickr modal-bottom sm:modal-middle">
    <div class="modal-box">
      <h3 class="ms-3 mb-4 text-lg font-bold">Generate Telemetry</h3>
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <form role="form" method="POST" action="{{ route('telemetries.generate') }}">
            @csrf
            @method('POST')
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Device Location</label>
                    <select class="select select-bordered w-full" name="device_location_id">
                        @foreach($device_locations as $device_location)
                            <option value="{{$device_location->id}}"
                                @selected(
                                request('device_location_id') == $device_location->id
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
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Date At</span>
                        </div>
                        <div class="inline-flex items-center relative">
                            <a href="#" class="btn btn-ghost btn-sm clear_tanggal btn-circle absolute right-0 mr-2">
                                <i class="fa-solid fa-times text-lg"></i>
                            </a>

                            <input type="text"
                                value="{{ old('bought_at', request('tanggal')) }}"
                                name="tanggal"
                                class="input input-bordered input-date-dialog2 input-primary w-full"
                            >
                        </div>
                        @error('tanggal')
                            <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </label>
                </div>
            </div>
            <div class="flex justify-between px-3">
                <button type="submit" class="btn btn-success w-full">
                   Generate
                </button>
            </div>
        </form>
    </div>
  </dialog>
  <div class="md:w-[90vw] mt-5 lg:w-2/3 lg:w-[80vw] w-full px-6 py-6 mx-auto">
    <!-- table 1 -->
    <div class="card bg-base-100 shadow-xl">
      <div class="p-6 flex flex-wrap pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold text-lg flex-auto">Telemetries</h6>
        <div class="join pt-4">
            <a class="btn btn-sm join-item btn-primary" href="{{route('telemetries.create')}}"><i class="fas fa-plus"></i>Tambah</a>
            <button class="btn btn-sm btn-success join-item" onclick="modal_generate.showModal()"><i class="fas fa-recycle"></i>Generate</button>
            <button class="btn btn-sm join-item" onclick="my_modal_5.showModal()"><i class="fas fa-search"></i>Search</button>
        </div>
      </div>
      <div class="flex-auto p-5 overflow-x-auto">
          <table class="table table-lg overflow-x-auto">
            <!-- head -->
            <thead>
              <tr>
                <th>Date</th>
                <th>Device</th>
                <th>Type</th>
                <th>Location</th>
                <th>City</th>
                <th>District</th>
                <th>PH</th>
                <th>TDS</th>
                <th>TSS</th>
                <th>Velocity</th>
                <th>Water Height</th>
                <th>Rainfall</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- row 1 -->
              @foreach ($telemetries as $telemetry)
                  <tr>
                    <td>{{$telemetry->created_at}}</td>
                    <td>{{ $telemetry->device_location->device->name }}</td>
                    <td>{{ $telemetry->device_location->device->type }}</td>
                    <td>{{ $telemetry->device_location->location->name }}</td>
                    <td>{{ $telemetry->device_location->location->city }}</td>
                    <td>{{ $telemetry->device_location->location->district }}</td>
                    <td>{{$telemetry->ph}}</td>
                    <td>{{$telemetry->tds}}</td>
                    <td>{{$telemetry->tss}}</td>
                    <td>{{$telemetry->velocity}}</td>
                    <td>{{$telemetry->water_height}}</td>
                    <td>{{$telemetry->rainfall}}</td>
                    <td class="justify-content-center items-center p-0">
                        <div class="join item-stretch flex sm:ps-3 xs:ps-3">
                            <a href="{{ route('telemetries.edit', encrypt($telemetry->id)) }}" class="btn join-item btn-xs btn-info h-full flex text-white items-center w-20">Ubah <i class="fas fa-edit"></i></a>
                            <form action="{{ route('telemetries.destroy', encrypt($telemetry->id)) }}" method="POST" class="h-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn join-item h-full flex items-center w-20 btn-error text-white btn-xs">
                                    <span class="ps-1">
                                            Archive <i class="fas fa-trash"></i>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
      </div>
      {{ $telemetries->links() }}
    </div>
  </div>

@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endpush

@push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        //message with sweetalert
        @if(session('status'))
            Swal.fire({
                icon: "success",
                title: "BERHASIL",
                text: "{{ session('status') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @elseif(session('error'))
            Swal.fire({
                icon: "error",
                title: "GAGAL!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif


    </script>
@endpush
