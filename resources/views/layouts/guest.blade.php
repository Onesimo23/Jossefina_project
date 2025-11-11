<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema de gestão</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    {{-- Background with animated gradient --}}
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">

        {{-- Animated background elements --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        {{-- Grid pattern overlay --}}
        <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>

        {{-- Content --}}
        <div class="relative min-h-screen flex items-center justify-center px-4 py-12">

            <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 items-center">

                {{-- Left side - Branding --}}
                <div class="hidden lg:block text-white space-y-8">
                    <div class="space-y-4">
                        <div class="inline-flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-full px-6 py-3 border border-white/20">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-blue-500 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span class="text-2xl font-bold">Sistema de gestão</span>
                        </div>

                        <h1 class="text-5xl font-bold leading-tight">
                            Bem-vindo de volta
                        </h1>

                        <p class="text-xl text-purple-200">
                            Aceda à sua conta e continue a sua jornada conosco.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                            <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">Seguro</h3>
                            <p class="text-sm text-purple-200">Seus dados protegidos com criptografia avançada</p>
                        </div>

                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                            <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">Rápido</h3>
                            <p class="text-sm text-purple-200">Acesso instantâneo à sua conta</p>
                        </div>
                    </div>
                </div>

                {{-- Right side - Form Card --}}
                <div class="w-full">
                    <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 overflow-hidden">

                        {{-- Mobile header --}}
                        <div class="lg:hidden bg-gradient-to-r from-purple-600 to-blue-600 p-6 text-center">
                            <div class="inline-flex items-center justify-center space-x-2 mb-2">
                                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-white">{{ config('app.name', 'Laravel') }}</h2>
                            </div>
                            <p class="text-purple-100 text-sm">Aceda à sua conta</p>
                        </div>

                        {{-- Form content --}}
                        <div class="p-8 lg:p-10">
                            <div class="hidden lg:block mb-8">
                                <h2 class="text-3xl font-bold text-gray-900 mb-2">Iniciar Sessão</h2>
                                <p class="text-gray-600">Insira suas credenciais para continuar</p>
                            </div>

                            {{-- Slot for login/register forms --}}
                            <div class="space-y-6">
                                {{ $slot }}
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="bg-gray-50 px-8 lg:px-10 py-6 border-t border-gray-100">
                            <p class="text-center text-sm text-gray-500">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
                            </p>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .bg-grid-pattern {
            background-image:
                linear-gradient(to right, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
        }
    </style>

</body>
</html>
