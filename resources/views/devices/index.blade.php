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
  <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
      <h3 class="ms-3 mb-4 text-lg font-bold">Cari Data</h3>
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <form role="form" method="GET" action="{{ route('devices.index') }}">
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Nama</label>
                    <input type="text" name="q" value="{{ old('q', request('q')) }}" placeholder="Name/ City/ District" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Type</label>
                    <select class="select select-bordered w-full max-w-xs" name="type">
                        <option value=""
                            @selected(
                                request('type') == ""
                            )
                        >Pilih Lokasi</option>
                        @foreach(["RTU", "Raspberry"] as $type)
                            <option value="{{$type}}"
                                @selected(request('type') == $type)
                            >{{$type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Phone Number</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', request('phone_number')) }}" placeholder="+6281273726622" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
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
  <div class="md:w-[90vw] mt-5 lg:w-2/3 lg:w-[80vw] w-full px-6 py-6 mx-auto">
    <!-- table 1 -->
    <div class="card bg-base-100 shadow-xl">
      <div class="p-6 flex pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold text-lg flex-auto">Device</h6>
        <div class="join">
            <a class="btn btn-sm join-item btn-primary" href="{{route('devices.create')}}"><i class="fas fa-plus"></i>Tambah</a>
            <button class="btn btn-sm join-item" onclick="my_modal_5.showModal()"><i class="fas fa-search"></i>Search</button>
        </div>
      </div>
      <div class="flex-auto p-5 overflow-x-auto">
          <table class="table table-lg overflow-x-auto">
            <!-- head -->
            <thead>
              <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Phone Number</th>
                <th>Bought At</th>
                <th>Used At</th>
                <th>Damaged At</th>
                <th>PH</th>
                <th>TDS</th>
                <th>TSS</th>
                <th>Velocity</th>
                <th>Rainfall</th>
                <th>Water Level</th>
                <th>Temperature</th>
                <th>Humidity</th>
                <th>Wind Direction</th>
                <th>Wind Speed</th>
                <th>Solar Radiation</th>
                <th>Evaporation</th>
                <th>State</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- row 1 -->
              @foreach ($devices as $device)
                  <tr>
                    <td>{{$device->name}}</td>
                    <td>{{$device->type}}</td>
                    <td>{{$device->phone_number}}</td>
                    <td>{{$device->bought_at}}</td>
                    <td>{{$device->used_at}}</td>
                    <td>{{$device->damaged_at}}</td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_ph) !!}
                    </td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_tds) !!}
                    </td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_tss) !!}
                    </td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_velocity) !!}
                    </td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_rainfall) !!}
                    </td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_water_height) !!}
                    </td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_temperature) !!}
                    </td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_humidity) !!}
                    </td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_wind_direction) !!}
                    </td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_wind_speed) !!}
                    </td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_solar_radiation) !!}
                    </td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_evaporation) !!}
                    </td>
                    <td>
                        {!! \App\Helpers\ViewHelper::render_condition($device->has_dissolve_oxygen) !!}
                    </td>
                    <td>
                        <span class="badge uppercase text-xs font-bold
                            @if($device->state == 'active')
                                bg-green-600 text-white
                            @else
                                bg-base-300 text-base-400
                            @endif
                            ">
                            {{$device->state}}
                        </span>
                    </td>
                    <td class="justify-content-center items-center p-0">
                        <div class="join item-stretch flex sm:ps-3 xs:ps-3">
                            <a href="{{ route('devices.edit', encrypt($device->id)) }}" class="btn join-item btn-xs btn-info h-full flex text-white items-center w-20">Ubah <i class="fas fa-edit"></i></a>
                            <form action="{{ route('devices.destroy', encrypt($device->id)) }}" method="POST" class="h-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn join-item h-full flex items-center w-20
                                        @if ($device->state == 'active')
                                            btn-error text-white
                                        @else
                                            btn-success text-white
                                        @endif
                                    btn-xs">
                                    <span class="ps-1">
                                        @if ($device->state == 'active')
                                            Archive <i class="fas fa-trash"></i>
                                        @else
                                            Active <i class="fas fa-check-circle"></i>
                                        @endif
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
      {{ $devices->links() }}
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
