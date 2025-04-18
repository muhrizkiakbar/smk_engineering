@extends('layouts.app')

@section('content')
<!-- Open the modal using ID.showModal() method -->
<div class="md:w-[90vw] mt-5 lg:w-2/3 lg:w-[80vw] w-full px-6 py-6 mx-auto justify-center">

    <dialog id="device_location_modal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="ms-3 mb-4 text-lg font-bold">Device Locations</h3>
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <div class="grid grid-cols-1 sm:grid-cols-3">
                @foreach ($device_locations as $device_location)
                    <div class="px-2 py-2">
                        <a href="{{route('enduser.telemetry.index', $device_location->id)}}" class="btn btn-outline w-full btn-lg h-full btn-ghost flex flex-row items-center">
                            <!-- Tambah div wrapper untuk ikon dengan lebar tetap -->
                            <div class="flex-none w-8 mr-2">
                                <i class="fa-solid fa-map-location-dot text-xl"></i>
                            </div>

                            <!-- Tambah container untuk teks dengan flex-1 -->
                            <div class="flex-1 min-w-0 text-left">
                                {{$device_location->device->name}} - {{$device_location->location->name}}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn btn-neutral w-full btn-md">Close</button>
                </form>
            </div>
        </div>
    </dialog>
    <div class="flex flex-col sm:flex-row pb-4 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="sm:flex-auto">
            <h6 class="font-bold text-lg">{{$telemetry->device_location->device->name.' - '.$telemetry->device_location->location->name}}</h6>
        </div>
        <div class="flex flex-col sm:flex-row">
            <button class="btn btn-sm btn-primary sm:m-0 my-2 me-0 sm:me-2" onclick="my_modal_5.showModal()"><i class="fas fa-camera-retro"></i>Photo Location</button>
            <button class="btn btn-sm btn-secondary" onclick="device_location_modal.showModal()"><i class="fas fa-map"></i>Change Locations</button>
        </div>
    </div>


    <div class="grid grid-cols-1 pt-4 lg:grid-cols-2 xl:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 gap-x-8 gap-y-4">
        <div class="stats shadow py-2">
            <div class="stat">
                <div class="stat-figure
                    @if ($telemetry->device_location->device->has_ph == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">
                    <i class="fa-solid text-3xl fa-droplet"></i>
                </div>
                <div class="stat-title">PH</div>
                <div id="ph_card" class="stat-value
                    @if ($telemetry->device_location->device->has_ph == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">{{$telemetry->ph ?? 0}}</div>
                <div class="stat-desc">21% more than last month</div>
            </div>
        </div>
        <div class="stats shadow py-2">
            <div class="stat">
                <div class="stat-figure
                    @if ($telemetry->device_location->device->has_tds == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">
                    <i class="fa-brands text-3xl fa-drupal"></i>
                </div>
                <div class="stat-title">TDS</div>
                <div id="tds_card" class="stat-value
                    @if ($telemetry->device_location->device->has_tds == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">{{$telemetry->tds ?? 0}}</div>
                <div class="stat-desc">21% more than last month</div>
            </div>
        </div>
        <div class="stats shadow py-2">
            <div class="stat">
                <div class="stat-figure
                    @if ($telemetry->device_location->device->has_tss == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">
                    <i class="fa-solid text-3xl fa-tornado"></i>
                </div>
                <div class="stat-title">TSS</div>
                <div id="tss_card" class="stat-value
                    @if ($telemetry->device_location->device->has_tss == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">{{$telemetry->tss ?? 0}}</div>
                <div class="stat-desc">Range quality standards between</div>
            </div>
        </div>
        <div class="stats shadow py-2">
            <div class="stat">
                <div class="stat-figure
                    @if ($telemetry->device_location->device->has_debit == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">
                    <i class="fa-solid text-3xl fa-house-flood-water-circle-arrow-right"></i>
                </div>
                <div class="stat-title">Debit</div>
                <div id="debit_card" class="stat-value
                    @if ($telemetry->device_location->device->has_debit == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">{{$telemetry->debit ?? 0}}</div>
                <div class="stat-desc">Range quality standards between</div>
            </div>
        </div>
        <div class="stats shadow py-2">
            <div class="stat">
                <div class="stat-figure
                    @if ($telemetry->device_location->device->has_rainfall == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">
                    <i class="fa-solid text-3xl fa-cloud-showers-heavy"></i>
                </div>
                <div class="stat-title">Rainfall</div>
                <div id="rainfall_card" class="stat-value
                    @if ($telemetry->device_location->device->has_rainfall == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">{{$telemetry->rainfall ?? 0}}</div>
                <div class="stat-desc">Range quality standards between</div>
            </div>
        </div>
        <div class="stats shadow py-2">
            <div class="stat">
                <div class="stat-figure
                    @if ($telemetry->device_location->device->has_water_height == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">
                    <i class="fa-solid text-3xl fa-water"></i>
                </div>
                <div class="stat-title">Water Level</div>
                <div id="water_height_card" class="stat-value
                    @if ($telemetry->device_location->device->has_water_height == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">{{$telemetry->water_height ?? 0}}</div>
                <div class="stat-desc">Range quality standards between</div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 pt-4 lg:grid-cols-2 xl:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 gap-x-8 gap-y-4">
        <div class="card w-full h-full bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">PH</h2>
                <canvas id="ph"></canvas>
            </div>
        </div>
        <div class="card w-full h-full bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">TDS</h2>
                <canvas id="tds"></canvas>
            </div>
        </div>
        <div class="card w-full h-full bg-base-100 shadow-xl">
            <div class="card-body ps-6">
                <h2 class="card-title">TSS</h2>
            </div>
            <canvas id="tss"></canvas>
        </div>
        <div class="card w-full h-full bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Debit</h2>
                <canvas id="debit"></canvas>
            </div>
        </div>
        <div class="card w-full h-full bg-base-100 shadow-xl">
            <div class="card-body pb-2">
                <h2 class="card-title">Rainfall</h2>
            </div>
            <canvas id="rainfall"></canvas>
        </div>
        <div class="card w-full h-full bg-base-100 shadow-xl">
            <div class="card-body pb-2">
                <h2 class="card-title">Water Level</h2>
            </div>
            <canvas class="ps-0 pb-2 pe-2" id="water_level"></canvas>
        </div>
    </div>
</div>

@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endpush

@push('scripts')
<script>
    window.$(function () {
        var telemetries = @json($telemetries);

        const ph_chart = document.getElementById('ph').getContext('2d');
        const tds_chart = document.getElementById('tds').getContext('2d');
        const tss_chart = document.getElementById('tss').getContext('2d');
        const debit_chart = document.getElementById('debit').getContext('2d');
        const rainfall_chart = document.getElementById('rainfall').getContext('2d');
        const water_height_chart = document.getElementById('water_level').getContext('2d');
        const ph_card = window.$('#ph_card');
        const tds_card = window.$('#tds_card');
        const tss_card = window.$('#tss_card');
        const rainfall_card = window.$('#rainfall_card');
        const water_height_card = window.$('#water_height_card');
        const debit_card = window.$('#debit_card');
        const device_photo_img = window.$('#device_photo_img');


        const data = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [
                {
                    label: 'Default Interpolation',
                    data: [],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: true,
                    tension: 0.4, // Mengatur ketegangan garis (interpolation)
                },
            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                },
                scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Hours'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                    }
                }
                }
            }
        };

        const myChart = new window.Chart(ph_chart, config);
        const myChart2 = new window.Chart(tds_chart, config);
        const myChart3 = new window.Chart(tss_chart, config);
        const myChart4 = new window.Chart(debit_chart, config);
        const myChart5 = new window.Chart(rainfall_chart, config);
        const myChart6 = new window.Chart(water_height_chart, config);

        let ph_telemetries = [];
        let tds_telemetries = [];
        let tss_telemetries = [];
        let rainfall_telemetries = [];
        let water_height_telemetries = [];
        let debit_telemetries = [];
        let device_photo = null;
        let ph = 0;
        let tds = 0;
        let tss = 0;
        let rainfall = 0;
        let debit = 0;
        let water_height = 0;
        let labels = [];

        function render_data(){
            update_chart(myChart, ph_telemetries, labels, "PH");
            update_chart(myChart2, tds_telemetries, labels, "TDS");
            update_chart(myChart3, tss_telemetries, labels, "TSS");
            update_chart(myChart4, rainfall_telemetries, labels, "Debit");
            update_chart(myChart5, debit_telemetries, labels, "Rainfall");
            update_chart(myChart6, water_height_telemetries, labels, "Water Level");

            ph_card.text(ph);
            tds_card.text(tds);
            tss_card.text(tss);
            rainfall_card.text(rainfall);
            water_height_card.text(water_height);
            debit_card.text(debit);
            device_photo_img.attr('src', device_photo);
        }

        function fetch_data(){
            window.$.ajax({
                url: '{{ route('enduser.telemetry.telemetry', encrypt($telemetry->device_location->id)) }}', // Ganti dengan URL API yang sesuai
                method: "GET",
                dataType: "json",
                success: function(response) {
                    ph_telemetries = response.telemetries.map(item => item.ph).reverse();
                    tds_telemetries = response.telemetries.map(item => item.tds).reverse();
                    tss_telemetries = response.telemetries.map(item => item.tss).reverse();
                    debit_telemetries = response.telemetries.map(item => item.debit).reverse();
                    water_height_telemetries = response.telemetries.map(item => item.water_height).reverse();
                    rainfall_telemetries = response.telemetries.map(item => item.rainfall).reverse();
                    labels = response.telemetries.map(item => formatDateTime(item.created_at)).sort();

                    device_photo = response.device_photo;
                    ph = response.ph;
                    tds = response.tds;
                    tss = response.tss;
                    rainfall = response.rainfall;
                    debit = response.debit;
                    water_height = response.water_height;

                    render_data();
                },
                error: function(xhr, status, error) {
                    console.error("Error saat mengambil data:", error);
                }
            });
        }



        function formatDateTime(datetime) {
            const date = new Date(datetime);

            const day = date.getDate().toString().padStart(2, '0'); // Ambil tanggal (dd)
            const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Ambil bulan (mm)
            const hours = date.getHours().toString().padStart(2, '0'); // Ambil jam (HH)
            const minutes = date.getMinutes().toString().padStart(2, '0'); // Ambil menit (ii)

            return `${hours}:${minutes}`;
        }

        function update_chart(chart, datas, label, label_dataset) {
            console.log(label_dataset)
            console.log(chart)
            chart.data.labels = label;
            chart.data.datasets[0].data = datas;
            chart.data.datasets[0].label = "";
            chart.update(); // Refresh chart with new data
        }

        fetch_data()


        setInterval(() => {
            fetch_data();
        }, 15 * 60 * 1000); // 60 menit * 60 detik * 1000 milidetik
    })
</script>
@endpush
