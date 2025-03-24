@extends('layouts.app')

@section('content')
<!-- Open the modal using ID.showModal() method -->
  <div class=" mt-5 w-full px-6 py-6 mx-auto">
    <div id="map" style="height: 80vh;"></div>
  </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endpush

@push('scripts')
<script>
    window.$(function () {

        const mapStyle={
          version: 8,
          sources: {
            'map-source': {
              type: 'raster',
              tiles: ['https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'],
              tileSize: 256,
              attribution:
                '\u003Ca href="https://www.maptiler.com/copyright/" target="_blank"\u003E&copy; MapTiler\u003C/a\u003E \u003Ca href="https://www.openstreetmap.org/copyright" target="_blank"\u003E&copy; OpenStreetMap contributors\u003C/a\u003E',
            },
          },
          layers: [
            {
              id: 'map-layer',
              type: 'raster',
              source: 'map-source',
            },
          ],
        }

        var devices = @json($device_locations);

        // Inisialisasi peta
        var map = new window.maplibregl.Map({
            container: 'map',
            style: mapStyle,
            center: [devices[0].longitude, devices[0].latitude],
            zoom: 11,
            minzoom: 11,
            maxzoom: 17,
        });


        // Tambahkan marker untuk setiap device
        devices.forEach(function(device) {
            var marker = new window.maplibregl.Marker()
                .setLngLat([device.longitude, device.latitude])
                .setPopup(
                    new maplibregl.Popup({ offset: 25 }) // Adjust offset if needed
                        .setHTML(`
                            <div class="flex">
                                <div class="flex-row">
                                    <h2 class="text-lg font-bold text-gray-950">${device.device_name} - ${device.location_name}</h2>
                                    <p class="text-gray-700">Sensor available: </p>
                                    ${ device.has_ph ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">PH</div>' : '' }
                                    ${ device.has_tds ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">TDS</div>' : '' }
                                    ${ device.has_tss ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">TSS</div>' : '' }
                                    ${ device.has_debit ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">debit</div>' : '' }
                                    ${ device.has_water_height ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">Water Height</div>' : '' }
                                    ${ device.has_rainfall ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">Rainfall</div>' : '' }
                                    ${ device.has_temperature ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">Temperature</div>' : '' }
                                    ${ device.has_humidity ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">Humidity</div>' : '' }
                                    ${ device.has_wind_direction ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">Wind Direction</div>' : '' }
                                    ${ device.has_wind_speed ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">Wind Speed</div>' : '' }
                                    ${ device.has_solar_radiation ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">Solar Radiation</div>' : '' }
                                    ${ device.has_evaporation ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">Evaporation</div>' : '' }
                                    ${ device.has_dissolve_oxygen ? '<div class="badge badge-sm badge-success text-white font-bold font-xxs">Dissolve Oxygen</div>' : '' }
                                    <div class="flex pt-4">
                                        <a href="/enduser/device_locations/${device.id}/telemetry" class="btn w-full btn-sm btn-outline btn-success">Dashboard</a>
                                    </div>
                                </div>
                            </div>
                        `)
                )
                .addTo(map);

            // Tambahkan label menggunakan elemen HTML
            const label = document.createElement('div');
            label.className = 'marker-label';
            label.innerHTML = `<p style="margin-top:12px;">${device.device_name}</p>`;
            label.style.position = 'absolute';
            label.style.background = 'transparent';
            label.style.padding = '4px 6px';
            label.style.fontSize = '12px';
            label.style.borderRadius = '4px';
            label.style.textAlign = 'center';
            label.style.fontWeight = 'bold';
            label.style.color = 'white';
            label.style.transform = 'translate(-50%, -50px)';

            // Tambahkan elemen label sebagai custom marker
            new window.maplibregl.Marker({ element: label })
                .setLngLat([device.longitude, device.latitude])
                .addTo(map);
        });

    })
</script>
@endpush
