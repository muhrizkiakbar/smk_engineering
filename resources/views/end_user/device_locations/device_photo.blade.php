@extends('layouts.app')

@push('style')
<style>
    .zoom-container {
      position: relative;
      overflow: hidden;
    }

    .zoom-img {
      transition: transform 0.3s ease;
      transform-origin: center;
    }

    .zoom-img.dragging {
      cursor: grabbing;
      transition: none; /* Disable transition during drag for smoother movement */
    }

    .zoom-controls {
      position: absolute;
      bottom: 20px;
      right: 20px;
      display: flex;
      gap: 10px;
      z-index: 50;
    }

</style>
@endpush
@section('content')
<!-- Open the modal using ID.showModal() method -->
<div class="md:w-[90vw] mt-5 lg:w-2/3 lg:w-[80vw] w-full px-6 py-6 mx-auto justify-center">
    <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
        <h3 class="ms-3 mb-4 text-lg font-bold">Cari Data</h3>
            <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <form role="form" method="GET" action="{{ route('enduser.device_locations.device_photos', $device_location->id) }}">
                <div class="flex flex-row mb-4 ">
                    <div class="px-3 w-full">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Created At</span>
                            </div>
                            <div class="inline-flex items-center relative">
                                <a href="#" class="btn btn-ghost btn-sm clear_tanggal btn-circle absolute right-0 mr-2">
                                    <i class="fa-solid fa-times text-lg"></i>
                                </a>
                                <input type="text"
                                    value="{{ old('created_at', request('created_at')) }}"
                                    name="created_at"
                                    class="input input-bordered input-date-dialog input-primary w-full"
                                >
                            </div>
                            @error('created_at')
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

    <input type="checkbox" id="imageModalToggle" class="modal-toggle hidden" />
    <div id="imageModal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl p-0 relative">
        <label for="imageModalToggle" class="btn btn-sm btn-circle absolute right-2 top-2 z-50 bg-base-100">✕</label>
        <div class="p-4">
            <h3 id="modalTitle" class="font-bold text-lg"></h3>
            <p id="modalDescription" class="py-1"></p>
        </div>

        <div id="zoomContainer" class="zoom-container flex justify-center items-center bg-base-300 relative" style="min-height: 400px;">
            <img id="modalImage" class="zoom-img max-h-[70vh]" src="" alt="Preview" />

            <div class="zoom-controls">
            <button id="zoomIn" class="btn btn-circle btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                <line x1="11" y1="8" x2="11" y2="14"></line>
                <line x1="8" y1="11" x2="14" y2="11"></line>
                </svg>
            </button>
            <button id="zoomOut" class="btn btn-circle btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                <line x1="8" y1="11" x2="14" y2="11"></line>
                </svg>
            </button>
            <button id="resetZoom" class="btn btn-circle btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 2v6h6"></path>
                <path d="M21 12A9 9 0 0 0 6 5.3L3 8"></path>
                <path d="M21 22v-6h-6"></path>
                <path d="M3 12a9 9 0 0 0 15 6.7l3-2.7"></path>
                </svg>
            </button>
            </div>
        </div>

        <div class="modal-action p-4">
            <label for="imageModalToggle" class="btn">Close</label>
        </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row pb-4 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="sm:flex-auto">
            <h6 class="font-bold text-lg">{{$device_location->device->name.' - '.$device_location->location->name}}</h6>
        </div>
        <div class="flex flex-col sm:flex-row">
            <button class="btn btn-sm btn-primary" onclick="my_modal_5.showModal()"><i class="fas fa-search"></i>Search</button>
        </div>
    </div>


    <div class="grid grid-cols-1 pt-4 lg:grid-cols-2 xl:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 gap-x-8 gap-y-4">
        <div class="card bg-base-100 w-96 shadow-sm">
            <figure>
                <img
                src="{{asset('storage/'.$device_photo->photo)}}"
                onclick="openImageModal('{{asset('storage/'.$device_photo->photo)}}','Photo Taken At {{$device_photo->created_at}}' , '')"
                alt="Camera" />
            </figure>
            <div class="flex flex-row py-2 px-2 items-center">
                <p class="text-sm flex-auto">Photo Taken At {{$device_photo->created_at}}</p>
                <div class="card-actions justify-end flex-col">
                    <button class="btn btn-xs btn-primary"
                        onclick="openImageModal('{{asset('storage/'.$device_photo->photo)}}','Photo Taken At {{$device_photo->created_at}}' , '')"
                    >Preview</button>
                </div>
            </div>

        </div>
        @foreach ($device_photos as $device_photo)
            <div class="card bg-base-100 w-96 shadow-sm">
                <figure>
                    <img
                    src="{{asset('storage/'.$device_photo->photo)}}"
                    onclick="openImageModal('{{asset('storage/'.$device_photo->photo)}}','Photo Taken At {{$device_photo->created_at}}' , '')"
                    alt="Camera" />
                </figure>
                <div class="flex flex-row py-2 px-2 items-center">
                    <p class="text-sm flex-auto">Photo Taken At {{$device_photo->created_at}}</p>
                    <div class="card-actions justify-end flex-col">
                        <button class="btn btn-xs btn-primary"
                            onclick="openImageModal('{{asset('storage/'.$device_photo->photo)}}','Photo Taken At {{$device_photo->created_at}}' , '')"
                        >Preview</button>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
    {{ $device_photos->links() }}

    @if ($device_photos->count() == 0)
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

@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endpush

@push('scripts')
<script>
 // Modal and zoom functionality
    let currentZoom = 1;
    const zoomStep = 0.2;
    const maxZoom = 3;
    const minZoom = 0.5;

    // Get elements
    const modalToggle = document.getElementById('imageModalToggle');
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const zoomContainer = document.getElementById('zoomContainer');
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');
    const zoomInBtn = document.getElementById('zoomIn');
    const zoomOutBtn = document.getElementById('zoomOut');
    const resetZoomBtn = document.getElementById('resetZoom');

    // Initialize variables for drag functionality
    let isDragging = false;
    let startX, startY;
    let translateX = 0, translateY = 0;

    // Open modal with image
    function openImageModal(imageSrc, title, description) {
      // Reset zoom and position
      resetZoom();

      // Set modal content
      modalImage.src = imageSrc;
      modalTitle.textContent = title;
      modalDescription.textContent = description;

      // Show modal
      modalToggle.checked = true;
    }

    // Zoom functions
    function zoomIn() {
      if (currentZoom < maxZoom) {
        currentZoom += zoomStep;
        updateZoom();
      }
    }

    function zoomOut() {
      if (currentZoom > minZoom) {
        currentZoom -= zoomStep;
        updateZoom();
      }
    }

    function resetZoom() {
      currentZoom = 1;
      translateX = 0;
      translateY = 0;
      updateZoom();
    }

    function updateZoom() {
      // Apply transform for zooming and panning
      modalImage.style.transform = `translate(${translateX}px, ${translateY}px) scale(${currentZoom})`;

      // Enable/disable dragging based on zoom level
      if (currentZoom > 1) {
        modalImage.style.cursor = 'grab';
      } else {
        modalImage.style.cursor = 'default';
        // Reset translation when zoomed out completely
        translateX = 0;
        translateY = 0;
      }
    }

    // Event listeners for zoom buttons
    zoomInBtn.addEventListener('click', zoomIn);
    zoomOutBtn.addEventListener('click', zoomOut);
    resetZoomBtn.addEventListener('click', resetZoom);

    // Mouse wheel zoom support
    zoomContainer.addEventListener('wheel', function(e) {
      e.preventDefault();
      if (e.deltaY < 0) {
        zoomIn();
      } else {
        zoomOut();
      }
    });

    // Mouse dragging functionality for panning
    modalImage.addEventListener('mousedown', function(e) {
      if (currentZoom > 1) {
        isDragging = true;
        startX = e.clientX;
        startY = e.clientY;

        // Add dragging class to disable transitions during drag for smooth movement
        modalImage.classList.add('dragging');
      }
    });

    window.addEventListener('mousemove', function(e) {
      if (!isDragging) return;

      // Calculate the distance moved
      const dx = e.clientX - startX;
      const dy = e.clientY - startY;

      // Update the translation values
      translateX += dx;
      translateY += dy;

      // Update image position immediately for smooth dragging
      modalImage.style.transform = `translate(${translateX}px, ${translateY}px) scale(${currentZoom})`;

      // Reset the start position for the next move
      startX = e.clientX;
      startY = e.clientY;
    });

    window.addEventListener('mouseup', function() {
      if (isDragging) {
        isDragging = false;
        modalImage.classList.remove('dragging');
      }
    });

    // Touch support for mobile devices
    modalImage.addEventListener('touchstart', function(e) {
      if (currentZoom > 1 && e.touches.length === 1) {
        isDragging = true;
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;

        // Add dragging class to disable transitions during drag
        modalImage.classList.add('dragging');

        // Prevent default to avoid page scrolling while dragging
        e.preventDefault();
      }
    });

    window.addEventListener('touchmove', function(e) {
      if (!isDragging) return;

      // Calculate the distance moved
      const dx = e.touches[0].clientX - startX;
      const dy = e.touches[0].clientY - startY;

      // Update the translation values
      translateX += dx;
      translateY += dy;

      // Update image position immediately for smooth dragging
      modalImage.style.transform = `translate(${translateX}px, ${translateY}px) scale(${currentZoom})`;

      // Reset the start position for the next move
      startX = e.touches[0].clientX;
      startY = e.touches[0].clientY;

      // Prevent default to avoid page scrolling while dragging
      e.preventDefault();
    });

    window.addEventListener('touchend', function() {
      if (isDragging) {
        isDragging = false;
        modalImage.classList.remove('dragging');
      }
    });

    // Close modal when clicking outside the content area
    modal.addEventListener('click', function(e) {
      if (e.target === modal) {
        modalToggle.checked = false;
      }
    });

</script>
@endpush
