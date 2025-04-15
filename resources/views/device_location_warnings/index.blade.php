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
        <form role="form" method="GET" action="{{ route('device_locations.index') }}">
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Device</label>
                    <select class="select select-bordered w-full" name="device_id">
                        <option value=""
                            @selected(
                                request('device_id') == ""
                            )
                        >Pilih Device</option>
                        @foreach($devices as $device)
                            <option value="{{$device->id}}"
                                @selected(
                                request('device_id') == $device->id
                                )
                            >{{$device->name.' ',$device->type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Location</label>
                    <select class="select select-bordered w-full" name="location_id">
                        <option value=""
                            @selected(
                                request('location_id') == ""
                            )
                        >Pilih Lokasi</option>
                        @foreach($locations as $location)
                            <option value="{{$location->id}}"
                                @selected(
                                    request('location_id') == $location->id
                                )
                            >{{$location->name.' - '.$location->city.' - '.$location->district}}</option>
                        @endforeach
                    </select>
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

<dialog id="modal_create" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
      <h3 class="ms-3 mb-4 text-lg font-bold">Create Warning</h3>
      <h3 class="ms-3 mb-4 text-lg font-bold" id="device_name_form"></h3>
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <form role="form" id="form_warning">
            @csrf
            <input type="hidden" name="device_location_id" id="device_location_id">
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Type</label>
                    <select class="select select-bordered w-full" name="type">
                        <option value="ph">PH</option>
                        <option value="tds">TDS</option>
                        <option value="tss">TSS</option>
                        <option value="rainfall">Rainfall</option>
                        <option value="water_height">Water Level(Water Height)</option>
                        <option value="debit">Debit</option>
                        <option value="temperature">Temperature</option>
                        <option value="humidity">Humidity</option>
                        <option value="wind_direction">Wind Direction</option>
                        <option value="wind_speed">Wind Speed</option>
                        <option value="solar_radiation">Solar Radiation</option>
                        <option value="evaporation">Evaporation</option>
                        <option value="dissolve_oxygen">Dissolve Oxygen</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Low Upper Threshold Start</label>
                    <input type="text"
                        name="low_upper_threshold_start" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Low Upper Threshold End</label>
                    <input type="text"
                        name="low_upper_threshold_end" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Middle Upper Threshold Start</label>
                    <input type="text"
                        name="middle_upper_threshold_start" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Middle Upper Threshold End</label>
                    <input type="text"
                        name="middle_upper_threshold_end" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">High Upper Threshold Start</label>
                    <input type="text"
                        name="high_upper_threshold_start" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">High Upper Threshold End</label>
                    <input type="text"
                        name="high_upper_threshold_end" class="input input-bordered input-primary w-full">
                </div>
            </div>

            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Low Bottom Threshold Start</label>
                    <input type="text"
                        name="low_bottom_threshold_start" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Low Bottom Threshold End</label>
                    <input type="text"
                        name="low_bottom_threshold_end" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Middle Bottom Threshold Start</label>
                    <input type="text"
                        name="middle_bottom_threshold_start" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Middle Bottom Threshold End</label>
                    <input type="text"
                        name="middle_bottom_threshold_end" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">High Bottom Threshold Start</label>
                    <input type="text"
                        name="high_bottom_threshold_start" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">High Bottom Threshold End</label>
                    <input type="text"
                        name="high_bottom_threshold_end" class="input input-bordered input-primary w-full">
                </div>
            </div>

            <div class="flex justify-between px-3">
                <button type="submit" class="btn btn-primary w-full">
                   Add
                </button>
            </div>
        </form>
    </div>
</dialog>

<dialog id="modal_update" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
      <h3 class="ms-3 mb-4 text-lg font-bold">Update Warning</h3>
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <form role="form" id="form_warning_update">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id">
            <input type="hidden" name="device_location_id" id="edit_device_location_id">
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Type</label>
                    <select class="select select-bordered w-full" name="type" id="edit_type">
                        <option value="ph">PH</option>
                        <option value="tds">TDS</option>
                        <option value="tss">TSS</option>
                        <option value="rainfall">Rainfall</option>
                        <option value="water_height">Water Level(Water Height)</option>
                        <option value="debit">Debit</option>
                        <option value="temperature">Temperature</option>
                        <option value="humidity">Humidity</option>
                        <option value="wind_direction">Wind Direction</option>
                        <option value="wind_speed">Wind Speed</option>
                        <option value="solar_radiation">Solar Radiation</option>
                        <option value="evaporation">Evaporation</option>
                        <option value="dissolve_oxygen">Dissolve Oxygen</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Low Upper Threshold Start</label>
                    <input type="text"
                        name="low_upper_threshold_start" id="edit_low_upper_threshold_start" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Low Upper Threshold End</label>
                    <input type="text"
                        name="low_upper_threshold_end" id="edit_low_upper_threshold_end" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Middle Upper Threshold Start</label>
                    <input type="text"
                        name="middle_upper_threshold_start" id="edit_middle_upper_threshold_start" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Middle Upper Threshold End</label>
                    <input type="text"
                        name="middle_upper_threshold_end" id="edit_middle_upper_threshold_end" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">High Upper Threshold Start</label>
                    <input type="text"
                        name="high_upper_threshold_start" id="edit_high_upper_threshold_start" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">High Upper Threshold End</label>
                    <input type="text"
                        name="high_upper_threshold_end" id="edit_high_upper_threshold_end" class="input input-bordered input-primary w-full">
                </div>
            </div>

            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Low Bottom Threshold Start</label>
                    <input type="text"
                        name="low_bottom_threshold_start" id="edit_low_bottom_threshold_start" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Low Bottom Threshold End</label>
                    <input type="text"
                        name="low_bottom_threshold_end" id="edit_low_bottom_threshold_end" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Middle Bottom Threshold Start</label>
                    <input type="text"
                        name="middle_bottom_threshold_start" id="edit_middle_bottom_threshold_start" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Middle Bottom Threshold End</label>
                    <input type="text"
                        name="middle_bottom_threshold_end" id="edit_middle_bottom_threshold_end" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">High Bottom Threshold Start</label>
                    <input type="text"
                        name="high_bottom_threshold_start" id="edit_high_bottom_threshold_start" class="input input-bordered input-primary w-full">
                </div>
            </div>
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">High Bottom Threshold End</label>
                    <input type="text"
                        name="high_bottom_threshold_end" id="edit_high_bottom_threshold_end" class="input input-bordered input-primary w-full">
                </div>
            </div>

            <div class="flex justify-between px-3">
                <button type="submit" class="btn btn-primary w-full">
                   Add
                </button>
            </div>
        </form>
    </div>
</dialog>

  <div class="md:w-[90vw] mt-5 lg:w-2/3 lg:w-[80vw] w-full px-6 py-6 mx-auto">
    <!-- table 1 -->
    <div class="card bg-base-100 shadow-xl">
      <div class="p-6 flex flex-warp pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold text-lg flex-auto">Device Location Warning</h6>
        <div class="join pt-4">
            <button class="btn btn-sm join-item" onclick="my_modal_5.showModal()"><i class="fas fa-search"></i>Search</button>
        </div>
      </div>
      <div class="flex-auto p-5 overflow-x-auto">
          <table class="table table-lg overflow-x-auto">
            <!-- head -->
            <thead>
              <tr>
                <th>ID</th>
                <th colspan="2">Device</th>
                <th colspan="2">type</th>
                <th colspan="2">Department</th>
                <th colspan="2">Location</th>
                <th colspan="2">City</th>
                <th colspan="2">District</th>
                <th colspan="2">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- row 1 -->
              @foreach ($device_locations as $device_location)
                    @php
                        $device_location_id = encrypt($device_location->id);
                    @endphp
                  <tr class="hover:bg-base-300 device-location"
                    id="{{$device_location_id}}"
                    data-device-location-id="{{$device_location_id}}"
                  >
                    <td>{{$device_location->id}}</td>
                    <td colspan="2">{{$device_location->device->name}}</td>
                    <td colspan="2">{{$device_location->device->type}}</td>
                    <td colspan="2">{{$device_location->department->name ?? ''}}</td>
                    <td colspan="2">{{$device_location->location->name}}</td>
                    <td colspan="2">{{$device_location->location->city}}</td>
                    <td colspan="2">{{$device_location->location->district}}</td>
                    <td colspan="2">
                        <button class="btn btn-sm btn-ghost btn-add-warning text-sm"
                            data-device-location-id="{{$device_location_id}}"
                            data-device-name="{{$device_location->device->name}}"
                            data-device-department-name="{{$device_location->department->name}}"
                            data-device-location-name="{{$device_location->location->name}}"
                            data-device-location-city="{{$device_location->location->city}}"
                            data-device-location-district="{{$device_location->location->district}}"
                        >
                            Add
                        </button>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
      </div>
      {{ $device_locations->links() }}
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
        // ========================== start method load data
        function load_data_warning(el){
            let device_location_id = $(el).data('device-location-id')

            $.ajax({
                url: `/device_location_warnings/${device_location_id}`,
                type: 'GET',
                success: function(response) {
                    render_tr_warnings(el, response)
                },
                error: function(xhr) {
                    console.error('Terjadi kesalahan:', xhr.responseText);
                }
            });
        }

        function render_tr_warnings(el, warnings){
            let device_location_id = $(el).data('device-location-id')
            $('.device-detail-row[data-parent-id="'+device_location_id+'"]').remove();

            let html = `
                <tr class="device-detail-row bg-base-200"  data-parent-id="${device_location_id}">
                    <th class="font-sans text-xs font-semibold">
                        Type
                    </th>
                    <th class="font-sans text-xs font-semibold">
                        High Upper Threshold End
                    </th>
                    <th class="font-sans text-xs font-semibold">
                        High Upper Threshold Start
                    </th>
                    <th class="font-sans text-xs font-semibold">
                        Middle Upper Threshold End
                    </th>
                    <th class="font-sans text-xs font-semibold">
                        Middle Upper Threshold Start
                    </th>
                    <th class="font-sans text-xs font-semibold">
                        Low Upper Threshold End
                    </th>
                    <th class="font-sans text-xs font-semibold">
                        Low Upper Threshold Start
                    </th>

                    <th class="font-sans text-xs font-semibold">
                        Low Bottom Threshold Start
                    </th>
                    <th class="font-sans text-xs font-semibold">
                        Low Bottom Threshold End
                    </th>
                    <th class="font-sans text-xs font-semibold">
                        Middle Bottom Threshold Start
                    </th>
                    <th class="font-sans text-xs font-semibold">
                        Middle Bottom Threshold End
                    </th>
                    <th class="font-sans text-xs font-semibold">
                        High Bottom Threshold Start
                    </th>
                    <th class="font-sans text-xs font-semibold">
                        High Bottom Threshold End
                    </th>
                    <th class="font-sans text-xs font-semibold">
                        Action
                    </th>
                </tr>
            `;

            warnings.forEach(item => {
                html += `
                    <tr class="device-detail-row bg-base-100 hover:bg-base-300"  data-parent-id="${device_location_id}" data-id="${item.id}">
                        <td>
                            ${item.type}
                        </td>
                        <td>
                            ${item.high_upper_threshold_end}
                        </td>
                        <td>
                            ${item.high_upper_threshold_start}
                        </td>
                        <td>
                            ${item.middle_upper_threshold_end}
                        </td>
                        <td>
                            ${item.middle_upper_threshold_start}
                        </td>
                        <td>
                            ${item.low_upper_threshold_end}
                        </td>
                        <td>
                            ${item.low_upper_threshold_start}
                        </td>

                        <td>
                            ${item.low_bottom_threshold_start}
                        </td>
                        <td>
                            ${item.low_bottom_threshold_end}
                        </td>
                        <td>
                            ${item.middle_bottom_threshold_start}
                        </td>
                        <td>
                            ${item.middle_bottom_threshold_end}
                        </td>
                        <td>
                            ${item.high_bottom_threshold_start}
                        </td>
                        <td>
                            ${item.high_bottom_threshold_end}
                        </td>

                        <td>
                            <div class="dropdown dropdown-end">
                                <button tabindex="0" class="btn btn-sm btn-ghost btn-square text-xs join-item">
                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-5 w-5 stroke-current"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path> </svg>
                                </button>
                                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <li>
                                        <button class=""
                                            data-device-location-id="${device_location_id}"
                                            data-id="${item.id}"
                                            data-type="${item.type}"

                                            data-high-upper-threshold-end="${item.high_upper_threshold_end}"
                                            data-high-upper-threshold-start="${item.high_upper_threshold_start}"
                                            data-middle-upper-threshold-end="${item.midle_upper_threshold_end}"
                                            data-middle-upper-threshold-start="${item.middle_upper_threshold_start}"
                                            data-low-upper-threshold-end="${item.low_upper_threshold_end}"
                                            data-low-upper-threshold-start="${item.low_upper_threshold_start}"

                                            data-low-bottom-threshold-start="${item.low_bottom_threshold_start}"
                                            data-low-bottom-threshold-end="${item.low_bottom_threshold_end}"
                                            data-middle-bottom-threshold-start="${item.middle_bottom_threshold_start}"
                                            data-middle-bottom-threshold-end="${item.middle_bottom_threshold_end}"
                                            data-high-bottom-threshold-start="${item.high_bottom_threshold_start}"
                                            data-high-bottom-threshold-end="${item.high_bottom_threshold_end}"

                                            onclick="load_modal_update(this)"
                                        >
                                            Ubah
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            data-device-location-id="${device_location_id}"
                                            data-id="${item.id}"
                                            data-type="${item.type}"
                                            data-upper="${item.upper_threshold}"
                                            data-bottom="${item.bottom_threshold}"
                                            onclick="delete_warning(this)"
                                        >
                                            Hapus
                                        </button>

                                    </li>
                                </ul>
                            </div>

                        </td>
                    </tr>
                `;
            });

            $(el).after(html);
        }
        // ========================== end method load data

        // ========================== start method create data

        function load_modal_create(el){
            let currentEl = $(el)
            let device_location_id = currentEl.data('device-location-id')
            let device_name = currentEl.data('device-name')
            let location_name = currentEl.data('device-location-name')
            $('#device_name_form').text(device_name+" - "+location_name)

            $('#device_location_id').val(device_location_id)

            document.getElementById('modal_create').showModal()
        }

        $('#form_warning').submit(function(e){
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: '/device_location_warnings',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function (res) {
                    console.log($('#device_location_id').val())
                    document.getElementById('modal_create').close();
                    $('#form_warning')[0].reset();
                    load_data_warning($('#'+$('#device_location_id').val()))
                },
                error: function (xhr) {
                    alert('Gagal menyimpan data!');
                    console.log(xhr.responseText);
                }
            });
        })

        // ========================== end method create data

        // ========================== start method update data

        function load_modal_update(el){
            let currentEl = $(el)
            let device_location_id = currentEl.data('device-location-id')
            let type = currentEl.data('type')

            let high_upper_threshold_end = currentEl.data('high-upper-threshold-end')
            let high_upper_threshold_start = currentEl.data('high-upper-threshold-start')
            let middle_upper_threshold_end = currentEl.data('middle-upper-threshold-end')
            let middle_upper_threshold_start = currentEl.data('middle-upper-threshold-start')
            let low_upper_threshold_end = currentEl.data('low-upper-threshold-end')
            let low_upper_threshold_start = currentEl.data('low-upper-threshold-start')

            let low_bottom_threshold_start = currentEl.data('low-bottom-threshold-start')
            let low_bottom_threshold_end = currentEl.data('low-bottom-threshold-end')
            let middle_bottom_threshold_start = currentEl.data('middle-bottom-threshold-start')
            let middle_bottom_threshold_end = currentEl.data('middle-bottom-threshold-end')
            let high_bottom_threshold_start = currentEl.data('high-bottom-threshold-start')
            let high_bottom_threshold_end = currentEl.data('high-bottom-threshold-end')

            let id = currentEl.data('id')

            $('#edit_device_location_id').val(device_location_id)
            $('#edit_type').val(type)

            $('#edit_high_upper_threshold_end').val(high_upper_threshold_end)
            $('#edit_high_upper_threshold_start').val(high_upper_threshold_start)
            $('#edit_middle_upper_threshold_end').val(middle_upper_threshold_end)
            $('#edit_middle_upper_threshold_start').val(middle_upper_threshold_start)
            $('#edit_low_upper_threshold_end').val(low_upper_threshold_end)
            $('#edit_low_upper_threshold_start').val(low_upper_threshold_start)

            $('#edit_low_bottom_threshold_start').val(low_bottom_threshold_start)
            $('#edit_low_bottom_threshold_end').val(low_bottom_threshold_end)
            $('#edit_middle_bottom_threshold_start').val(middle_bottom_threshold_start)
            $('#edit_middle_bottom_threshold_end').val(middle_bottom_threshold_end)
            $('#edit_high_bottom_threshold_start').val(high_bottom_threshold_start)
            $('#edit_high_bottom_threshold_end').val(high_bottom_threshold_end)

            $('#edit_id').val(id)

            document.getElementById('modal_update').showModal()
        }

        $('#form_warning_update').submit(function(e){
            e.preventDefault();

            let formData = $(this).serialize();
            let id = $('#edit_id').val();

            $.ajax({
                url: '/device_location_warnings/'+id,
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function (res) {
                    document.getElementById('modal_update').close();
                    load_data_warning($('#'+$('#edit_device_location_id').val()))
                    $('#form_warning_update')[0].reset();
                },
                error: function (xhr) {
                    alert('Gagal menyimpan data!');
                    console.log(xhr.responseText);
                }
            });
        })

        // ========================== end method update data

        // ========================== start method delete data

        function delete_warning(el){
            let currentEl = $(el)
            let device_location_id = currentEl.data('device-location-id')
            let type = currentEl.data('type')
            let upper = currentEl.data('upper')
            let bottom = currentEl.data('bottom')
            let id = currentEl.data('id')


            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/device_location_warnings/' + id,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // csrf token
                        },
                        success: function (res) {
                            Swal.fire(
                                'Terhapus!',
                                'Data berhasil dihapus.',
                                'success'
                            );
                            // Opsional: Hapus baris dari tabel
                            load_data_warning($('#'+device_location_id))
                        },
                        error: function (xhr) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus.',
                                'error'
                            );
                            console.error(xhr.responseText);
                        }
                    });
                }
            })

        }

        // ========================== end method delete data


        $('.device-location').click(function(){
            load_data_warning(this)
        })

        $('.btn-add-warning').click(function(){
            load_modal_create(this)
        })


    </script>
@endpush
