@extends('layouts.app')

@section('content')
<!-- Open the modal using ID.showModal() method -->
<div class="md:w-[90vw] mt-5 lg:w-2/3 lg:w-[80vw] w-full px-6 py-6 mx-auto justify-center">

    <dialog id="my_modal_5" class="modal w-full modal-bottom sm:modal-middle">
        <div class="modal-box w-full" style="max-width:none;">
        <h3 class="ms-3 mb-4 text-lg font-bold">Device Photo</h3>
            <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
                <div class="flex flex-row mb-4 justify-center">
                        @if ($device_photo != null)
                            <div class="flex flex-col">
                                <p class="label-text ps-0 pb-4">Last Updated At {{$device_photo->updated_at}}</p>
                                <img
                                    src="{{asset('storage/'.$device_photo->photo)}}"
                                alt="image" />
                            </div>
                        @else
                            <div class="empty-data-component">
                                <div class="empty-data-container flex justify-center items-center h-96">
                                    <div class="empty-data-icon text-6xl text-gray-400 mb-4">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <div class="empty-data-message text-center">
                                        <h2 class="text-lg font-bold mb-2">No Photo Found</h2>
                                        <p class="text-sm text-gray-500">It looks like there's no photo to display.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                </div>
                <div class="justify-items-center">
                    <form action="{{ route('enduser.telemetry.create_device_photo', $telemetry->device_location_id) }}" method="POST" class="w-full justify-items-center">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn join-item flex items-center w-1/3 btn-primary">
                            <span>
                                Take Picture <i class="fas fa-camera-retro"></i>
                            </span>
                        </button>
                    </form>
                </div>
        </div>
    </dialog>
    <div class="flex pb-4 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold text-lg flex-auto">{{$telemetry->device_location->device->name.' - '.$telemetry->device_location->location->name}}</h6>
            <button class="btn btn-sm btn-primary" onclick="my_modal_5.showModal()"><i class="fas fa-camera-retro"></i>Photo Location</button>
    </div>


    <div class="grid grid-cols-1 pt-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-3 gap-x-8 gap-y-4">
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
                <div class="stat-value
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
                <div class="stat-value
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
                <div class="stat-value
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
                    @if ($telemetry->device_location->device->has_velocity == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">
                    <i class="fa-solid text-3xl fa-house-flood-water-circle-arrow-right"></i>
                </div>
                <div class="stat-title">Velocity</div>
                <div class="stat-value
                    @if ($telemetry->device_location->device->has_velocity == true)
                        text-primary
                    @else
                        text-neutral-content
                    @endif
                ">{{$telemetry->velocity ?? 0}}</div>
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
                <div class="stat-value
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
                <div class="stat-title">Water Height</div>
                <div class="stat-value
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
    <div class="grid grid-cols-1 pt-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-3 gap-x-8 gap-y-4">
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
                <h2 class="card-title">Velocity</h2>
                <canvas id="velocity"></canvas>
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
                <h2 class="card-title">Water Height</h2>
            </div>
            <canvas class="ps-0 pb-2 pe-2" id="water_height"></canvas>
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
        const water_height_chart = document.getElementById('water_height').getContext('2d');

        const data = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [
                {
                label: 'Default Interpolation',
                data: [4, 2.3, 5.5, 6.6, 9.2, 10.3, 7.5],
                borderColor: 'rgba(255, 99, 132, 1)',
                fill: false,
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
                    display: false,
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
        const myChart4 = new window.Chart(velocity_chart, config);
        const myChart5 = new window.Chart(rainfall_chart, config);
        const myChart6 = new window.Chart(water_height_chart, config);
    })
</script>
@endpush
