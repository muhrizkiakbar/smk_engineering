@extends('layouts.app')

@section('content')
  <div class="md:w-[90vw] mt-5 lg:w-2/3 w-full px-6 py-6 mx-auto">
    <!-- table 1 -->
    <div class="card bg-base-100 shadow-xl">
      <div class="p-6 flex pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold text-lg flex-auto">Ubah User</h6>
      </div>
      <div class="flex-auto p-5">
        <form role="form" method="POST" class="p-4" action="{{ route('users.update', encrypt($user->id)) }}">
            @csrf
            @method('PUT')
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Name</span>
                    </div>
                    <input type="text"
                        value="{{ old('name', request('name', $user->name)) }}"
                        name="name"
                        placeholder="Name"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('name')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Username</span>
                    </div>
                    <input type="text"
                        value="{{ old('username', request('username', $user->username)) }}"
                        name="username"
                        placeholder="Username"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('username')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Email</span>
                    </div>
                    <input type="text"
                        value="{{ old('email', request('email', $user->email)) }}"
                        name="email"
                        placeholder="Email"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('email')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Confirmation Password</span>
                    </div>
                    <input type="password"
                        name="password_confirmation"
                        placeholder="Confirmation Password"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('password_confirmation')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Password</span>
                    </div>
                    <input type="password"
                        name="password"
                        placeholder="Password"
                        class="input input-bordered input-primary w-full"
                    >
                    @error('password')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                  <div class="label">
                    <span class="label-text">Type User</span>
                  </div>
                    <select class="select select-bordered w-full" name="type_user">
                        @foreach(["admin", "client"] as $type_user)
                            <option value="{{$type_user}}"
                                @selected(old('type_user', request('type_user', $user->type_user)) == $type_user)
                            >{{$type_user}}</option>
                        @endforeach
                    </select>
                    @error('type_user')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="mb-4 px-3">
                <label class="form-control w-full">
                  <div class="label">
                    <span class="label-text">State</span>
                  </div>
                    <select class="select select-bordered w-full" name="state">
                        @foreach(["active", "archive"] as $state)
                            <option value="{{$state}}"
                                @selected(old('state', request('state', $user->state)) == $state)
                            >{{$state}}</option>
                        @endforeach
                    </select>
                    @error('state')
                        <p class="mb-0 mt-1 leading-tight text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="flex justify-between px-3">
                <button type="submit" class="btn btn-sm btn-primary">
                    Simpan
                </button>
                <a class="btn btn-sm" href="{{route('users.index')}}">Kembali</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
    <script src={{asset("assets/js/library.js")}}></script>
    <script>
    </script>
@endpush
