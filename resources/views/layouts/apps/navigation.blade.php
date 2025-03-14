<div class="flex justify-center">
    <div class="navbar bg-base-100 mx-4 mt-4 rounded-lg shadow-lg sm:w-full md:w-[90vw] lg:w-[75vw]">
      <div class="flex-none">
        <div class="drawer">
          <input id="my-drawer" type="checkbox" class="drawer-toggle" />
          <div class="drawer-content">
            <!-- Page content here -->
            <label for="my-drawer" class="btn btn-square btn-ghost drawer-button">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                class="inline-block h-5 w-5 stroke-current">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </label>
          </div>
            @include('layouts.apps.sidebar')
        </div>
      </div>
      <div class="flex-1">
        <a class="btn btn-ghost text-xl">Telemetry</a>
      </div>
      <div class="flex-none">
        <div class="mx-4 font-semibold hidden md:block">
            {{ Auth::user()->name }}
        </div>
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    <img src="http://202.10.35.221:9001/adarolaravelproduction/avatar.jpeg" alt="Uploaded Image" class="max-w-sm">
                </div>
            </div>
          <ul
            tabindex="0"
            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
            <li>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    @method('POST')

                    <button href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
</div>
