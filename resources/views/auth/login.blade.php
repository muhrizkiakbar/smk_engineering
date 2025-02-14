<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex my-4">
          <div class="card card-compact bg-base-100 w-full sm:w-full shadow-xl">
            <div class="card-body xl:mx-4">
                <h2 class="card-title">Login</h2>
                <form method="POST" action="{{ route('login') }}" class="">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-control">
                        <label for="username" class="mb-3 text-sm font-bold">NIP</label>
                        <x-text-input id="username" class="input input-bordered mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="nip" />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="form-control mt-4">
                        <label for="name" class="mb-3 text-sm font-bold">Password</label>
                        <x-text-input id="password" class="input input-bordered mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="form-control mt-4">
                        <label for="remember_me" class="label cursor-pointer justify-start">
                            <input id="remember_me" type="checkbox" class="checkbox checkbox-primary" name="remember">
                            <span class="label-text ms-2">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between mt-4">
                        @if (Route::has('password.request'))
                            <a class="link link-primary text-sm" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <button type="submit" class="btn btn-primary">
                        Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>

