@extends('layouts.app')

@section('content')
<!-- Open the modal using ID.showModal() method -->
<div class="md:w-[90vw] mt-5 lg:w-2/3 lg:w-[80vw] w-full px-6 py-6 mx-auto justify-center">
    <div class="grid grid-cols-1 pt-4 lg:grid-cols-2 xl:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 gap-x-8 gap-y-4">
        <!-- device -->
        <div class="stats shadow py-2">
            <div class="stat">
                <div class="stat-figure
                    text-primary
                ">
                    <i class="fa-solid text-3xl fa-tachograph-digital fa-fw"></i>
                </div>
                <div class="stat-title">Total Devices Used</div>
                <div id="ph_card" class="stat-value text-primary">{{$telemetry->ph ?? 0}}</div>
                <div class="stat-desc whitespace-normal text-sm md:text-base">Total devices used into locations</div>
            </div>
        </div>
        <div class="stats shadow py-2">
            <div class="stat">
                <div class="stat-figure
                        text-success
                ">
                    <i class="fa-solid text-3xl fa-tachograph-digital fa-fw"></i>
                </div>
                <div class="stat-title">Total Devices</div>
                <div id="ph_card" class="stat-value text-success">{{$telemetry->ph ?? 0}}</div>
                <div class="stat-desc whitespace-normal text-sm md:text-base">Total devices including used device and broken device</div>
            </div>
        </div>
        <div class="stats shadow py-2">
            <div class="stat">
                <div class="stat-figure
                        text-neutral-content
                ">
                    <i class="fa-solid text-3xl fa-tachograph-digital fa-fw"></i>
                </div>
                <div class="stat-title">Total Broken Device</div>
                <div id="ph_card" class="stat-value text-neutral-content">{{$telemetry->ph ?? 0}}</div>
                <div class="stat-desc whitespace-normal text-sm md:text-base">Total broken devices that field of broken at was filled</div>
            </div>
        </div>
        <!-- lokasi -->
        <div class="stats shadow py-2">
            <div class="stat">
                <div class="stat-figure
                        text-primary
                ">
                    <i class="fa-solid text-3xl fa-map-location-dot"></i>
                </div>
                <div class="stat-title">Active Location</div>
                <div id="ph_card" class="stat-value text-primary">{{$telemetry->ph ?? 0}}</div>
                <div class="stat-desc whitespace-normal text-sm md:text-base">Active location that used at all</div>
            </div>
        </div>
        <div class="stats shadow py-2">
            <div class="stat">
                <div class="stat-figure
                        text-success
                ">
                    <i class="fa-solid text-3xl fa-map-location-dot"></i>
                </div>
                <div class="stat-title">Locations</div>
                <div id="ph_card" class="stat-value text-success">{{$telemetry->ph ?? 0}}</div>
                <div class="stat-desc whitespace-normal text-sm md:text-base">Total location</div>
            </div>
        </div>
        <div class="stats shadow py-2">
            <div class="stat">
                <div class="stat-figure
                        text-neutral-content
                ">
                    <i class="fa-solid text-3xl fa-map-location-dot"></i>
                </div>
                <div class="stat-title">Archived Location</div>
                <div id="ph_card" class="stat-value text-neutral-content">{{$telemetry->ph ?? 0}}</div>
                <div class="stat-desc whitespace-normal text-sm md:text-base">Archived location that is not used at all</div>
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
</script>
@endpush

