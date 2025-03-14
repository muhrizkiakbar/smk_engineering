<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
        <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100 md:me-5 xl:me-5 lg:me-5">
            <div class="flex flex-col items-center">
                <div class="my-5 mx-4">
                    <a href="/" class="fill-current text-primary">
                        <img src="https://minioapi.telemetry-adaro.id/adarolaravelproduction/adaro_telemetry.svg" alt="Uploaded Image">
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" class="">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-control">
                        <label for="username" class="mb-3 text-sm font-bold">Username</label>
                        <x-text-input id="username" class="input input-bordered mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
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

                        <button type="submit" class="btn w-full btn-primary">
                        Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
</x-guest-layout>

