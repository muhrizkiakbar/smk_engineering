@extends('layouts.app')

@section('content')
@php
    use Carbon\Carbon;
@endphp
<!-- Open the modal using ID.showModal() method -->
<div class="md:w-[90vw] mt-5 lg:w-2/3 lg:w-[80vw] w-full px-6 py-6 mx-auto justify-center">
    <div class="flex flex-col sm:flex-row pb-4 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="sm:flex-auto">
            <h6 class="font-bold text-lg">Control PH Sensor</h6>
        </div>
        <div class="flex flex-col sm:flex-row">
        </div>
    </div>

    <div class="grid grid-cols-1 pt-2 lg:grid-cols-2 xl:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 gap-x-8 gap-y-4">
        <div class="flex flex-col">
            <div class="py-2">
                <div class="collapse collapse-arrow bg-base-100 border-base-300">
                    <input type="checkbox" />
                    <div class="collapse-title font-semibold">SPASS01</div>
                    <div class="collapse-content text-sm">
                        <div class="grid grid-cols-1 pt-4 lg:grid-cols-2 xl:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 gap-x-8 gap-y-4">
                            <div class="card w-full h-full bg-base-100 border shadow-md text-primary">
                                <div class="flex flex-col px-4 pt-4">
                                    <h2 class="">PH</h2>
                                </div>
                                <div class="flex flex-row pb-4 px-4">
                                    <div class="flex-auto align-center">
                                        <p class="text-3xl text-red font-bold">10</p>
                                    </div>
                                    <i class="fa-solid text-3xl fa-droplet"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card w-full h-100 sm:h-full bg-base-100 shadow-xl">
                <canvas id="tds" class="p-2 h-100"></canvas>
            </div>
        </div>
        <div class="card w-full h-full bg-base-100 shadow-xl pt-3">
            <h2 class="card-title flex ps-4 pt-4 pb-4">TDS</h2>
            <div class="chart-container">
                <canvas id="tds" class="p-0 h-1"></canvas>
            </div>
        </div>
        <div class="card w-full h-full bg-base-100 shadow-xl">
            <h2 class="card-title flex ps-4 pt-4 pb-4">TSS</h2>
            <div class="chart-container">
                <canvas id="tss" class=" h-1"></canvas>
            </div>
        </div>
        <div class="card w-full h-full bg-base-100 shadow-xl">
            <h2 class="card-title flex ps-4 pt-4 pb-4">Velocity</h2>
            <div class="chart-container">
                <canvas id="velocity" class=" h-1"></canvas>
            </div>
        </div>
        <div class="card w-full h-full bg-base-100 shadow-xl">
            <h2 class="card-title flex ps-4 pt-4 pb-4">Rainfall</h2>
            <div class="chart-container">
                <canvas id="rainfall" class=" h-1"></canvas>
            </div>
        </div>
        <div class="card w-full h-full bg-base-100 shadow-xl">
            <h2 class="card-title flex ps-4 pt-4 pb-4">Water Level</h2>
            <div class="chart-container">
                <canvas id="water_level" class=" h-1"></canvas>
            </div>
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
        const velocity_chart = document.getElementById('velocity').getContext('2d');
        const rainfall_chart = document.getElementById('rainfall').getContext('2d');
        const water_height_chart = document.getElementById('water_level').getContext('2d');
        const ph_card = window.$('#ph_card');
        const tds_card = window.$('#tds_card');
        const tss_card = window.$('#tss_card');
        const rainfall_card = window.$('#rainfall_card');
        const water_height_card = window.$('#water_height_card');
        const velocity_card = window.$('#velocity_card');
        const device_photo_img = window.$('#device_photo_img');


        const data = {
            labels: [],
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

        let ph_telemetries = [];
        let tds_telemetries = [];
        let tss_telemetries = [];
        let rainfall_telemetries = [];
        let water_height_telemetries = [];
        let velocity_telemetries = [];
        let device_photo = null;
        let ph = 0;
        let tds = 0;
        let tss = 0;
        let rainfall = 0;
        let velocity = 0;
        let water_height = 0;
        let labels = [];

        function render_data(){
            update_chart(myChart, ph_telemetries, labels, "PH");
            update_chart(myChart2, tds_telemetries, labels, "TDS");
            update_chart(myChart3, tss_telemetries, labels, "TSS");
            update_chart(myChart4, rainfall_telemetries, labels, "Velocity");
            update_chart(myChart5, velocity_telemetries, labels, "Rainfall");
            update_chart(myChart6, water_height_telemetries, labels, "Water Level");

            ph_card.text(ph);
            tds_card.text(tds);
            tss_card.text(tss);
            rainfall_card.text(rainfall);
            water_height_card.text(water_height);
            velocity_card.text(velocity);
            device_photo_img.attr('src', device_photo);
        }

        function fetch_data(){
            window.$.ajax({
                url: '{{ route('enduser.device_locations.telemetry_json', 1)}}', // Ganti dengan URL API yang sesuai
                method: "GET",
                dataType: "json",
                success: function(response) {
                    ph_telemetries = response.telemetries.map(item => item.ph).reverse();
                    tds_telemetries = response.telemetries.map(item => item.tds).reverse();
                    tss_telemetries = response.telemetries.map(item => item.tss).reverse();
                    velocity_telemetries = response.telemetries.map(item => item.velocity).reverse();
                    water_height_telemetries = response.telemetries.map(item => item.water_height).reverse();
                    rainfall_telemetries = response.telemetries.map(item => item.rainfall).reverse();
                    labels = response.telemetries.map(item => formatDateTime(item.created_at)).sort();
                    console.log(labels);

                    device_photo = response.device_photo;
                    ph = response.ph;
                    tds = response.tds;
                    tss = response.tss;
                    rainfall = response.rainfall;
                    velocity = response.velocity;
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

        function render_element(object) {
            return `<div class="flex flex-col">
                <div class="py-2">
                    <div class="collapse collapse-arrow bg-base-100 border-base-300">
                        <input type="checkbox" />
                        <div class="collapse-title font-semibold">SPASS01</div>
                        <div class="collapse-content text-sm">
                            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 gap-x-8 gap-y-4">
                                <div class="card w-full h-full bg-base-100 border shadow-md text-primary">
                                    <div class="flex flex-col px-4 pt-4">
                                        <h2 class="">PH</h2>
                                    </div>
                                    <div class="flex flex-row pb-4 px-4">
                                        <div class="flex-auto align-center">
                                            <p class="text-3xl text-red font-bold">10</p>
                                        </div>
                                        <i class="fa-solid text-3xl fa-droplet"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card w-full h-100 sm:h-full bg-base-100 shadow-xl">
                    <canvas id="ph" class="p-2 h-100"></canvas>
                </div>
            </div>`;
        }

        setInterval(() => {
            fetch_data();
        }, 5 * 60 * 1000); // 60 menit * 60 detik * 1000 milidetik

    })
</script>
@endpush
