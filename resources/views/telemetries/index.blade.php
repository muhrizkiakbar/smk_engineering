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
                                value="{{ old('tanggal', request('tanggal')) }}"
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

  <dialog id="modal_import" class="modal modal-flatpickr modal-bottom sm:modal-middle">
    <div class="modal-box">
      <h3 class="ms-3 mb-4 text-lg font-bold">Import Telemetry</h3>
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <form role="form" method="POST" action="{{ route('telemetries.import') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-control w-full">
                <div class="flex flex-col items-center justify-center bg-base-100 border-2 border-dashed border-primary/50 rounded-lg p-6 mb-4 relative">
                    <input type="file" id="fileInput" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateFileName(this)"/>
                    <div id="uploadPlaceholder">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-primary/70 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="text-sm text-center text-base-content/70">
                            Drag and drop file here atau<br>
                            <span class="text-primary">klik untuk memilih file</span>
                        </p>
                    </div>
                    <div id="fileDetails" class="hidden flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-success mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="font-medium text-center" id="fileName">filename.ext</p>
                        <p class="text-xs text-base-content/70 mt-1" id="fileSize">0 KB</p>
                        <button type="button" class="btn btn-xs btn-ghost mt-2" onclick="resetFileInput()">
                            Remove
                        </button>
                    </div>
                    @error('file')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex justify-between px-3">
                <button type="submit" class="btn btn-success w-full" id="uploadButton">
                   Import
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
            <a class="btn btn-sm btn-primary join-item" href="{{route('telemetries.create')}}"><i class="fas fa-plus"></i>Tambah</a>
            <div class="dropdown dropdown-end">
                <button tabindex="0" class="btn btn-sm join-item">Actions <i class="fa-solid fa-chevron-down"></i></button>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <button class="" onclick="my_modal_5.showModal()"><i class="fas fa-search"></i>Search</button>
                    </li>
                    <li>
                        <button onclick="modal_generate.showModal()"><i class="fas fa-recycle"></i>Generate</button>
                    </li>
                    <li>
                        <button onclick="modal_import.showModal()">
                        <i class="fa-solid fa-download"></i>
                        Import</button>
                    </li>
                </ul>
            </div>
        </div>
      </div>
      <div class="flex-auto p-5 overflow-x-auto">
          <table class="table table-lg">
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
                    <td>{{$telemetry->water_height}}</td>
                    <td>{{round($telemetry->debit, 2)}}</td>
                    <td>{{$telemetry->rainfall}}</td>
                    <td>{{$telemetry->temperature}}</td>
                    <td>{{$telemetry->humidity}}</td>
                    <td>{{$telemetry->wind_direction}}</td>
                    <td>{{$telemetry->wind_speed}}</td>
                    <td>{{$telemetry->solar_radiation}}</td>
                    <td>{{$telemetry->evaporation}}</td>
                    <td>{{$telemetry->dissolve_oxygen}}</td>
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

        function updateFileName(input) {
            const uploadPlaceholder = document.getElementById('uploadPlaceholder');
            const fileDetails = document.getElementById('fileDetails');
            const fileNameElement = document.getElementById('fileName');
            const fileSizeElement = document.getElementById('fileSize');
            const uploadButton = document.getElementById('uploadButton');

            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Display file name
                fileNameElement.textContent = file.name;

                // Display file size
                const fileSize = formatFileSize(file.size);
                fileSizeElement.textContent = fileSize;

                // Show file details and hide placeholder
                uploadPlaceholder.classList.add('hidden');
                fileDetails.classList.remove('hidden');
                fileDetails.classList.add('flex');

                // Enable upload button
                uploadButton.disabled = false;
            }
        }

        function resetFileInput() {
            const fileInput = document.getElementById('fileInput');
            const uploadPlaceholder = document.getElementById('uploadPlaceholder');
            const fileDetails = document.getElementById('fileDetails');
            const uploadButton = document.getElementById('uploadButton');

            // Reset file input
            fileInput.value = '';

            // Show placeholder and hide file details
            uploadPlaceholder.classList.remove('hidden');
            fileDetails.classList.add('hidden');
            fileDetails.classList.remove('flex');

            // Disable upload button
            uploadButton.disabled = true;
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

    </script>
@endpush
