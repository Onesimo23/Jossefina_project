<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
        }

        .sidebar-collapsed {
            transform: translateX(-100%);
        }

        .main-content {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content-expanded {
            margin-left: 0;
        }

        .main-content-collapsed {
            margin-left: 18rem;
        }

        .sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }

        .nav-item {
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(to bottom, #6366f1, #8b5cf6);
            transform: scaleY(0);
            transition: transform 0.2s ease;
        }

        .nav-item:hover::before {
            transform: scaleY(1);
        }

        .nav-item:hover {
            background: rgba(99, 102, 241, 0.08);
            padding-left: 1.25rem;
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0.03) 100%);
            font-weight: 600;
            color: #4f46e5;
        }

        .nav-item.active::before {
            transform: scaleY(1);
        }

        .badge {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .7;
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .notification-dropdown {
            animation: slideDown 0.2s ease-out;
        }

        .notification-item {
            transition: all 0.2s ease;
        }

        .notification-item:hover {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.05) 0%, transparent 100%);
            transform: translateX(4px);
        }

        .notification-badge-bounce {
            animation: bounceIn 0.3s ease-out;
        }

        @media (max-width: 1024px) {
            .main-content-collapsed {
                margin-left: 0;
            }
        }

        /* Custom Scrollbar para dropdown */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar w-72 bg-white shadow-2xl">
        <div class="h-full flex flex-col">
            <!-- Logo Section -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-gray-200 bg-gradient-to-r from-indigo-600 to-purple-600">
                <div class="flex items-center space-x-3">
                    <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center shadow-lg transform hover:scale-105 transition">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Sistema</h1>
                    </div>
                </div>
                <button id="closeSidebar" class="lg:hidden text-white hover:bg-white/20 p-2 rounded-lg transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 overflow-y-auto py-6 px-4">
                <!-- Main Section -->
                <div class="space-y-1 mb-8">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Menu Principal</p>

                    <a href="{{ route('dashboard') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h4"></path>
                        </svg>
                        <span class="text-sm">Dashboard</span>
                    </a>

                    @can('viewAny', App\Models\Project::class)
                    <a href="{{ route('projects.manage') }}" class="nav-item flex items-center justify-between px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-sm">Projetos</span>
                        </div>
                        <span class="badge bg-indigo-100 text-indigo-600 text-xs px-2.5 py-1 rounded-full font-medium">3</span>
                    </a>
                    @endcan

                    @if(in_array(auth()->user()->role, ['admin', 'coordinator']))
                    <a href="{{ route('activities.manage') }}"
                        class="nav-item flex items-center space-x-3 px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('activities.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <span class="text-sm">Atividades</span>
                    </a>


                    <a href="{{ route('enrollments.manage', ['activity' => 1]) }}"
                       class="nav-item flex items-center space-x-3 px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('enrollments.manage') ? 'active' : '' }}">
                        <x-heroicon-o-users class="w-5 h-5 text-pink-500"/>
                        <span class="text-sm"> Gerir Inscrições</span>
                    </a>

                    <a href="{{ route('reports.index') }}"
                       class="nav-item flex items-center space-x-3 px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6M7 7h10M5 21h14"></path>
                        </svg>
                        <span class="text-sm">Relatórios</span>
                    </a>
                    @endif

                    <a href="{{ route('enrollments.my') }}"
                        class="nav-item flex items-center space-x-3 px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('enrollments.my') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="text-sm">Minhas Inscrições</span>
                    </a>

                     

                </div>

                <!-- Settings Section -->
                <div class="space-y-1 pt-6 border-t border-gray-200">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Configurações</p>

                    <a href="#" class="nav-item flex items-center space-x-3 px-4 py-3.5 text-gray-700 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="text-sm">Equipe</span>
                    </a>

                    <a href="#" class="nav-item flex items-center space-x-3 px-4 py-3.5 text-gray-700 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm">Configurações</span>
                    </a>

                    <a href="{{ route('profile') }}" class="nav-item flex items-center space-x-3 px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-sm">Meu Perfil</span>
                    </a>
                </div>
            </nav>

            <!-- User Info Footer -->
            <div class="p-4 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <div class="flex items-center space-x-3 p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-11 h-11 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg text-lg">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name ?? 'Usuário' }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? 'user@email.com' }}</p>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden opacity-0"></div>

    <!-- Main Content -->
    <div id="mainContent" class="main-content main-content-collapsed lg:main-content-collapsed min-h-screen flex flex-col">
        <!-- Top Navigation Bar -->
        <header class="h-20 bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
            <div class="h-full px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Menu Toggle Button -->
                    <button id="toggleSidebar" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg p-2 hover:bg-gray-100 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Search Bar -->
                    <div class="hidden sm:block">
                        <div class="relative">
                            <input type="text" placeholder="Pesquisar..." class="w-72 pl-11 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm transition shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side Navigation -->
                <div class="flex items-center space-x-4">
                    <!-- Sistema de Notificações Melhorado -->
                    <div class="relative" x-data="{ open: false, notifications: [] }"
                        x-init="
                            // Buscar notificações ao carregar
                            fetch('{{ route('dialogue.notifications.latest') }}', {
                                credentials: 'same-origin',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data && data.notifications) {
                                    notifications = data.notifications;
                                }
                            });

                            // Escutar eventos de novas mensagens
                            document.addEventListener('dialogue-message-sent', () => {
                                fetch('{{ route('dialogue.notifications.latest') }}', {
                                    credentials: 'same-origin',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data && data.notifications) {
                                        notifications = data.notifications;
                                    }
                                });
                            });
                         ">

                        <!-- Botão de Notificações -->
                        <button @click="open = !open"
                            class="relative p-2.5 rounded-xl hover:bg-gray-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>

                            <!-- Badge de Contador -->
                            <span x-show="notifications.length > 0"
                                x-text="notifications.length"
                                class="notification-badge-bounce absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-gradient-to-r from-red-500 to-pink-500 rounded-full shadow-lg">
                            </span>
                        </button>

                        <!-- Dropdown de Notificações -->
                        <div x-show="open"
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="notification-dropdown absolute right-0 mt-3 w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden z-50"
                            style="display: none;">

                            <!-- Header do Dropdown -->
                            <div class="px-5 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                        </svg>
                                        Notificações
                                    </h3>
                                    <span x-show="notifications.length > 0"
                                        x-text="notifications.length + ' nova' + (notifications.length > 1 ? 's' : '')"
                                        class="text-xs font-semibold text-indigo-600 bg-indigo-100 px-3 py-1 rounded-full">
                                    </span>
                                </div>
                            </div>

                            <!-- Lista de Notificações -->
                            <div class="max-h-[400px] overflow-y-auto custom-scroll">
                                <!-- Quando há notificações -->
                                <template x-if="notifications.length > 0">
                                    <div class="divide-y divide-gray-100">
                                        <template x-for="(notification, index) in notifications" :key="index">
                                            <a :href="notification.activity_url || '#'"
                                                class="notification-item block px-5 py-4 hover:bg-gradient-to-r hover:from-indigo-50/50">
                                                <div class="flex items-start gap-3">
                                                    <!-- Avatar/Ícone -->
                                                    <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md flex-shrink-0">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                        </svg>
                                                    </div>

                                                    <!-- Conteúdo da Notificação -->
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-semibold text-gray-900 mb-1" x-text="notification.title"></p>
                                                        <p class="text-sm text-gray-600 mb-2 line-clamp-2" x-text="notification.message"></p>

                                                        <!-- Metadados -->
                                                        <div class="flex items-center gap-3 text-xs text-gray-500">
                                                            <span class="flex items-center gap-1">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                                <span x-text="notification.time"></span>
                                                            </span>
                                                            <span class="flex items-center gap-1 text-indigo-600 font-medium">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                                </svg>
                                                                Ver chat
                                                            </span>
                                                        </div>

                                                        <!-- Indicador de não lida -->
                                                        <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-2"></div>
                                                    </div>
                                            </a>
                                        </template>
                                    </div>
                                </template>

                                <!-- Quando não há notificações -->
                                <template x-if="notifications.length === 0">
                                    <div class="px-5 py-12 text-center">
                                        <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900 mb-1">Nenhuma notificação</p>
                                        <p class="text-xs text-gray-500">Você está em dia com tudo! 🎉</p>
                                    </div>
                                </template>
                            </div>

                            <!-- Footer do Dropdown -->
                            <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
                                <button @click="notifications = []; open = false"
                                    class="w-full text-center text-sm font-semibold text-indigo-600 hover:text-indigo-700 py-2 hover:bg-white rounded-lg transition-all">
                                    Marcar todas como lidas
                                </button>
                            </div>
                        </div>
                    </div>

                    <livewire:layout.navigation />
                </div>
            </div>
        </header>

        <!-- Page Heading -->
        @if (isset($header))
        <div class="bg-white border-b border-gray-200 shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-start space-x-4">
                    <div class="h-14 w-1.5 bg-gradient-to-b from-indigo-500 to-purple-600 rounded-full"></div>
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">
                            {{ $header }}
                        </h1>
                        <p class="text-sm text-gray-500">Gerencie e acompanhe suas informações de forma eficiente</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                    <div class="text-sm text-gray-600">
                        © {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
                    </div>
                    <div class="flex space-x-6 text-sm">
                        <a href="#" class="text-gray-500 hover:text-indigo-600 transition font-medium">Privacidade</a>
                        <a href="#" class="text-gray-500 hover:text-indigo-600 transition font-medium">Termos</a>
                        <a href="#" class="text-gray-500 hover:text-indigo-600 transition font-medium">Suporte</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scroll to Top Button -->
    <button id="scrollTop" class="hidden fixed bottom-8 right-8 bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-4 rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 z-50 hover:scale-110">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        let sidebarOpen = window.innerWidth >= 1024;

        function toggleSidebar() {
            sidebarOpen = !sidebarOpen;

            if (window.innerWidth < 1024) {
                // Mobile behavior
                if (sidebarOpen) {
                    sidebar.classList.remove('sidebar-collapsed');
                    overlay.classList.remove('hidden');
                    setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                } else {
                    overlay.classList.add('opacity-0');
                    setTimeout(() => {
                        sidebar.classList.add('sidebar-collapsed');
                        overlay.classList.add('hidden');
                    }, 300);
                }
            } else {
                // Desktop behavior
                if (sidebarOpen) {
                    sidebar.classList.remove('sidebar-collapsed');
                    mainContent.classList.remove('main-content-expanded');
                    mainContent.classList.add('main-content-collapsed');
                } else {
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.remove('main-content-collapsed');
                    mainContent.classList.add('main-content-expanded');
                }
            }
        }

        toggleBtn?.addEventListener('click', toggleSidebar);
        closeBtn?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                overlay.classList.add('hidden');
                overlay.classList.add('opacity-0');
                if (sidebarOpen) {
                    sidebar.classList.remove('sidebar-collapsed');
                    mainContent.classList.add('main-content-collapsed');
                }
            } else {
                mainContent.classList.remove('main-content-collapsed');
                mainContent.classList.add('main-content-expanded');
                if (!sidebarOpen) {
                    sidebar.classList.add('sidebar-collapsed');
                }
            }
        });

        // Scroll to top functionality
        const scrollTopBtn = document.getElementById('scrollTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.remove('hidden');
            } else {
                scrollTopBtn.classList.add('hidden');
            }
        });

        scrollTopBtn?.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        async function fetchDialogueNotification() {
            try {
                const res = await fetch("{{ route('dialogue.notifications.latest') }}", {
                    credentials: 'same-origin',
                    headers: {'X-Requested-With', 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                });
                if (!res.ok) return;
                const data = await res.json();
                const textEl = document.getElementById('notificationText');
                const countEl = document.getElementById('notificationCount');

                if (!textEl || !countEl) return;

                if (data && data.count > 0 && data.project_title) {
                    textEl.textContent = `Nova mensagem no projecto: ${data.project_title}`;
                    countEl.textContent = String(data.count);
                    countEl.classList.remove('hidden');
                } else {
                    textEl.textContent = 'Sem notificações novas';
                    countEl.textContent = '0';
                    countEl.classList.add('hidden');
                }
            } catch (err) {
                console.error('Erro ao buscar notificações de diálogo', err);
            }
        }

        async function markDialogueNotificationsRead() {
            try {
                const res = await fetch("{{ route('dialogue.notifications.markRead') }}", {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                });
                if (!res.ok) return;
                document.getElementById('notificationText').textContent = 'Sem notificações novas';
                const countEl = document.getElementById('notificationCount');
                countEl.textContent = '0';
                countEl.classList.add('hidden');
            } catch (err) {
                console.error('Erro ao marcar notificações como lidas', err);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchDialogueNotification();

            document.addEventListener('dialogue-message-sent', () => {
                // Recarrega estado do header (consultando DB)
                fetchDialogueNotification();
            });

            const btn = document.getElementById('notificationButton');
            btn?.addEventListener('click', async () => {
                // Ao abrir o painel marcamos como lidas (pode ajustar)
                await markDialogueNotificationsRead();
            });
        });
    </script>
</body>

</html>
