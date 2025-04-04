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
        <form role="form" method="GET" action="{{ route('undelivered_telemetries.index') }}">
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
  <div class="md:w-[90vw] mt-5 lg:w-2/3 lg:w-[80vw] w-full px-6 py-6 mx-auto">
    <!-- table 1 -->
    <div class="card bg-base-100 shadow-xl">
      <div class="p-6 flex flex-wrap pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold text-lg flex-auto">Undelivered Telemetries</h6>
        <div class="join pt-4">
            <button class="btn btn-sm join-item" onclick="my_modal_5.showModal()"><i class="fas fa-search"></i>Search</button>
        </div>
      </div>
      <div class="flex-auto p-5 overflow-x-auto">
          <table class="table table-lg overflow-x-auto">
            <!-- head -->
            <thead>
              <tr>
                <th>Date</th>
                <th>Phone Number</th>
                <th>PH</th>
                <th>TDS</th>
                <th>TSS</th>
                <th>Water Level</th>
                <th>Debit</th>
                <th>Rainfall</th>
                <th>Temperature</th>
                <th>Humidity</th>
                <th>Wind Direction</th>
                <th>Wind Speed</th>
                <th>Solar Radiation</th>
                <th>Evaporation</th>
                <th>Dissolve Oxygen</th>
              </tr>
            </thead>
            <tbody>
              <!-- row 1 -->
              @foreach ($telemetries as $telemetry)
                  <tr>
                    <td>{{$telemetry->created_at}}</td>
                    <td>{{$telemetry->phone_number}}</td>
                    <td>{{$telemetry->ph}}</td>
                    <td>{{$telemetry->tds}}</td>
                    <td>{{$telemetry->tss}}</td>
                    <td>{{$telemetry->water_height}}</td>
                    <td>{{$telemetry->debit}}</td>
                    <td>{{$telemetry->rainfall}}</td>
                    <td>{{$telemetry->temperature}}</td>
                    <td>{{$telemetry->humidity}}</td>
                    <td>{{$telemetry->wind_direction}}</td>
                    <td>{{$telemetry->wind_speed}}</td>
                    <td>{{$telemetry->solar_radiation}}</td>
                    <td>{{$telemetry->evaporation}}</td>
                    <td>{{$telemetry->dissolve_oxygen}}</td>
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
