<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 text-white shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-gray-300">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('doctores.index')" :active="request()->routeIs('doctores.index')" class="text-white hover:text-gray-300">
                        {{ __('Doctores') }}
                    </x-nav-link>
                    <!--<x-nav-link :href="route('doctores.create')" :active="request()->routeIs('doctores.create')" class="text-white hover:text-gray-300">
                        {{ __('Agregar Doctor') }}
                    </x-nav-link> -->
                    
                    <x-nav-link :href="route('pacientes.index')" :active="request()->routeIs('pacientes.index')" class="text-white hover:text-gray-300">
                        {{ __('Pacientes') }}
                    </x-nav-link>
                      <!--<x-nav-link :href="route('pacientes.create')" :active="request()->routeIs('pacientes.create')" class="text-white hover:text-gray-300">
                        {{ __('Agregar Paciente') }}
                    </x-nav-link> -->
                    <x-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.index')" class="text-white hover:text-gray-300">
                        {{ __('Servicios') }}
                    </x-nav-link>
                      <!--<x-nav-link :href="route('servicios.create')" :active="request()->routeIs('servicios.create')" class="text-white hover:text-gray-300">
                        {{ __('Agregar Servicio') }}
                    </x-nav-link> -->
                    <x-nav-link :href="route('secretarias.index')" :active="request()->routeIs('secretarias.index')" class="text-white hover:text-gray-300">
                        {{ __('Secretarias') }}
                    </x-nav-link>
                      <!--<x-nav-link :href="route('secretarias.create')" :active="request()->routeIs('secretarias.create')" class="text-white hover:text-gray-300">
                        {{ __('Agregar Secretaria') }}
                    </x-nav-link> -->
                    <x-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.index')" class="text-white hover:text-gray-300">
                        {{ __('Citas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('consultas.index')" :active="request()->routeIs('consultas.index')" class="text-white hover:text-gray-300">
                        {{ __('Consultas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.index')" class="text-white hover:text-gray-300">
                        {{ __('Ventas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.index')" class="text-white hover:text-gray-300">
                        {{ __('Ventas') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 111.414 1.414l-4 4a1 1 011.414 0l-4-4a1 1 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-gray-700 hover:bg-gray-100">
                            {{ __('Ver Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="text-gray-700 hover:bg-gray-100" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-300 hover:bg-blue-700 focus:outline-none focus:bg-blue-700 focus:text-gray-300 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-blue-700">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('doctores.index')" :active="request()->routeIs('doctores.index')" class="text-white hover:bg-blue-700">
                {{ __('Doctores') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pacientes.index')" :active="request()->routeIs('pacientes.index')" class="text-white hover:bg-blue-700">
                {{ __('Pacientes') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.index')" class="text-white hover:bg-blue-700">
                {{ __('Servicios') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('secretarias.index')" :active="request()->routeIs('secretarias.index')" class="text-white hover:bg-blue-700">
                {{ __('Secretarias') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.index')" class="text-white hover:bg-blue-700">
                {{ __('Citas') }}
            </x-responsive-nav-link>

        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-100">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-200">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-blue-700">
                    {{ __('Ver Perfil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="text-white hover:bg-blue-700" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
