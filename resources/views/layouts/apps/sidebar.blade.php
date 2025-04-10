<div class="drawer-side z-[99999]">
    <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
    <div class="flex">
        <aside class="h-fit sm:h-screen menu top-0 flex flex-col bg-base-200 overflow-y-auto">
            <!-- Header -->
            <div class="flex justify-between p-2">
                <!-- Logo -->
                    <img src="https://minioapi.telemetry-adaro.id/adarolaravelproduction/adaro_telemetry.svg" alt="Uploaded Image">
            </div>

            <!-- Body -->
            <div class="flex flex-col border-y border-base-300 px-6 pt-4 grow">
            @if (Auth::user()->type_user == 'admin')
                <div class="flex justify-between items-center">
                    <h2 class="font-bold">Admin</h2>
                </div>

                <!-- Links -->
                <div class="flex flex-col divide-y divide-base-300">
                    <ul class="menu px-0 py-4">
                        <li class="py-1">
                            <a href="{{route('dashboard')}}"
                                class="{{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}"
                            >
                                <i class="fa-solid fa-house fa-fw"></i>
                                Home
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{route('departments.index')}}"
                                class="{{ Route::currentRouteName() === 'departments.index' ? 'active' : '' }}"
                            >
                                <i class="fa-solid fa-building fa-fw"></i>
                                Departments
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{route('users.index')}}"
                                class="{{ Route::currentRouteName() === 'users.index' ? 'active' : '' }}"
                            >
                                <i class="fa-solid fa-user fa-fw"></i>
                                User
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{route('devices.index')}}"
                                class="{{ Route::currentRouteName() === 'devices.index' ? 'active' : '' }}"
                            >
                                <i class="fa-solid fa-hard-drive fa-fw"></i>
                                Device
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{route('locations.index')}}"
                                class="{{ Route::currentRouteName() === 'locations.index' ? 'active' : '' }}"
                            >
                                <i class="fa-solid fa-location fa-fw"></i>
                                Location
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{route('device_locations.index')}}"
                                class="{{ Route::currentRouteName() === 'device_locations.index' ? 'active' : '' }}"
                            >
                                <i class="fa-solid fa-map-location-dot fa-fw"></i>
                                Device Location
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{route('device_locations.index')}}"
                                class="{{ Route::currentRouteName() === 'device_locations.index' ? 'active' : '' }}"
                            >
                                <i class="fa-solid fa-circle-radiation fa-fw"></i>
                                Early Warning System
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{route('telemetries.index')}}"
                                class="{{ Route::currentRouteName() === 'telemetries.index' ? 'active' : '' }}"
                            >
                                <i class="fa-solid fa-tachograph-digital fa-fw"></i>
                                Telemetry
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{route('undelivered_telemetries.index')}}"
                                class="{{ Route::currentRouteName() === 'undelivered_telemetries.index' ? 'active' : '' }}"
                            >
                                <i class="fa-solid fa-triangle-exclamation fa-fw"></i>
                                Undelivered Telemetry
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{route('real_telemetries.index')}}"
                                class="{{ Route::currentRouteName() === 'real_telemetries.index' ? 'active' : '' }}"
                            >
                                <i class="fa-solid fa-circle-check fa-fw"></i>
                                Original Telemetry
                            </a>
                        </li>
                    </ul>
                </div>
            @endif

            @if (Auth::user()->type_user == "admin" || Auth::user()->type_user == 'client')
                <div class="flex flex-col divide-y divide-base-300">
                    <div class="flex justify-between items-center">
                        <h2 class="font-bold">Client
                        </h2>
                    </div>
                    <ul class="menu px-0 py-4">
                        <li class="py-1">
                            <a href="{{route('enduser.device_locations.index')}}"
                                class="{{ Route::currentRouteName() === 'enduser.device_locations.index' ? 'active' : '' }}"
                            >
                                <i class="fa-solid fa-map-location-dot fa-fw"></i>
                                Device Location
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
            </div>

            <div class="flex justify-center items-center p-2">
                <a>
                    <label class="flex flex-row items-center cursor-pointer gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="5"></circle>
                        <path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"></path>
                    </svg>
                    <input type="checkbox" value="dracula" class="toggle theme-controller">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                    </label>
                </a>
            </div>
        </aside>
    </div>
</div>
