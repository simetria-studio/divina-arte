<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divina Arte - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @livewireStyles --}}
    <script src="https://unpkg.com/imask"></script>
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple {
            border-color: #e5e7eb;
            border-radius: 0.375rem;
            min-height: 2.5rem;
            padding: 0.25rem;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #6366f1;
            box-shadow: 0 0 0 1px rgba(99, 102, 241, 0.2);
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e0e7ff;
            border: none;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            margin: 0.125rem;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #4f46e5;
            margin-right: 0.25rem;
        }
        .select2-dropdown {
            border-color: #e5e7eb;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
    @endpush
</head>
<body class="bg-gray-50">
    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <!-- Logo -->
            <div class="flex items-center space-x-3 px-6 py-5 border-b border-indigo-800">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-xl font-bold text-white">Divina Arte</span>
            </div>

            <!-- Menu -->
            <nav class="mt-6 px-4">
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-indigo-200 uppercase tracking-wider px-3 mb-2">Principal</p>
                    <a href="#" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg bg-indigo-800 text-white">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    <p class="text-xs font-semibold text-indigo-200 uppercase tracking-wider px-3 mt-6 mb-2">Gestão</p>
                    <a href="{{ route('clientes.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-indigo-100 hover:bg-indigo-800 transition-colors {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Clientes
                        <span class="ml-auto bg-indigo-900 text-xs py-0.5 px-2 rounded-full">150</span>
                    </a>

                    <a href="{{ route('estoque.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-indigo-100 hover:bg-indigo-800 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Estoque
                        <span class="ml-auto bg-yellow-500 text-xs py-0.5 px-2 rounded-full">12</span>
                    </a>

                    <a href="{{ route('materia-prima.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-indigo-100 hover:bg-indigo-800 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2M7 7h10"/>
                        </svg>
                        Matéria Prima
                    </a>

                    <p class="text-xs font-semibold text-indigo-200 uppercase tracking-wider px-3 mt-6 mb-2">Vendas</p>
                    <a href="{{ route('produtos.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-indigo-100 hover:bg-indigo-800 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Produtos
                        <span class="ml-auto bg-green-500 text-xs py-0.5 px-2 rounded-full">45</span>
                    </a>

                    <a href="{{ route('pedidos.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-indigo-100 hover:bg-indigo-800 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Pedidos
                        <span class="ml-auto bg-red-500 text-xs py-0.5 px-2 rounded-full">8</span>
                    </a>

                    <a href="#" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-indigo-100 hover:bg-indigo-800 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Lançamentos
                    </a>
                </div>
            </nav>

            <!-- User Profile -->
            <div class="absolute bottom-0 left-0 right-0 border-t border-purple-800/50 p-4">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center w-full text-left">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-purple-400" 
                             src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=7C3AED&color=fff" 
                             alt="{{ Auth::user()->name }}">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-purple-200">{{ Auth::user()->email }}</p>
                        </div>
                        <svg class="ml-auto h-5 w-5 text-purple-200" 
                             :class="{'rotate-180': open}"
                             fill="none" 
                             stroke="currentColor" 
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="user-dropdown">
                        <div class="px-4 py-3">
                            <p class="text-sm">Logado como</p>
                            <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="border-t border-gray-100">
                            <a href="#" class="user-dropdown-item">
                                <div class="flex items-center">
                                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Meu Perfil
                                </div>
                            </a>
                            <a href="#" class="user-dropdown-item">
                                <div class="flex items-center">
                                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Configurações
                                </div>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="user-dropdown-item w-full text-left">
                                    <div class="flex items-center text-red-600">
                                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Sair
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="bg-white shadow-sm mb-8 rounded-lg">
                <div class="flex items-center justify-between px-6 py-4">
                    <button id="menu-toggle" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    
                    <div class="flex-1 ml-4 lg:ml-0">
                        <div class="relative">
                            <input type="text" class="search-input" placeholder="Buscar...">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="notification-badge">3</span>
                        </button>

                        <button class="relative p-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="notification-badge">5</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">@yield('header')</h1>
                <p class="mt-1 text-sm text-gray-500">@yield('subheader')</p>
            </div>

            <!-- Main Content Area -->
            @yield('content')
        </div>
    </div>

    @livewireScripts
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Mova os scripts para antes do fechamento do body -->
    <script>
        // Menu Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mainContent = document.querySelector('.main-content');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });
    </script>

    <!-- Adicione o stack de scripts aqui -->
    @stack('scripts')
</body>
</html> 