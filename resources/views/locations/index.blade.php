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
        <form role="form" method="GET" action="{{ route('locations.index') }}">
            <div class="flex flex-row mb-4 ">
                <div class="px-3 w-full">
                    <label for="from" class="label">Nama</label>
                    <input type="text" name="q" value="{{ old('q', request('q')) }}" placeholder="Name/ City/ District" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
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
        <h6 class="font-bold text-lg flex-auto">Locations</h6>
        <div class="join">
            <a class="btn btn-sm join-item btn-primary" href="{{route('locations.create')}}"><i class="fas fa-plus"></i>Tambah</a>
            <button class="btn btn-sm join-item" onclick="my_modal_5.showModal()"><i class="fas fa-search"></i>Search</button>
        </div>
      </div>
      <div class="flex-auto p-5 overflow-x-auto">
          <table class="table table-lg overflow-x-auto">
            <!-- head -->
            <thead>
              <tr>
                <th>Name</th>
                <th>City</th>
                <th>District</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- row 1 -->
              @foreach ($locations as $location)
                  <tr>
                    <td>{{$location->name}}</td>
                    <td>{{$location->city}}</td>
                    <td>{{$location->district}}</td>
                    <td>{{$location->description}}</td>
                    <td>
                        <span class="badge uppercase text-xs font-bold
                            @if($location->state == 'active')
                                bg-green-600 text-white
                            @else
                                bg-base-300 text-base-400
                            @endif
                            ">
                            {{$location->state}}
                        </span>
                    </td>
                    <td class="justify-content-center items-center p-0">
                            <div class="join item-stretch flex sm:ps-3 xs:ps-3">
                                <a href="{{ route('locations.edit', encrypt($location->id)) }}" class="btn join-item btn-xs btn-info h-full flex text-white items-center w-20">Ubah <i class="fas fa-edit"></i></a>
                                <form action="{{ route('locations.destroy', encrypt($location->id)) }}" method="POST" class="h-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn join-item h-full flex items-center w-20
                                            @if ($location->state == 'active')
                                                btn-error text-white
                                            @else
                                                btn-success text-white
                                            @endif
                                        btn-xs">
                                        <span class="ps-1">
                                            @if ($location->state == 'active')
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
      {{ $locations->links() }}
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
