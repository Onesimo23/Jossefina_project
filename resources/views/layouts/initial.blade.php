<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Sistema') }}</title>
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        .nav-link {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            color: #4f46e5;
            background-color: rgba(79, 70, 229, 0.1);
            margin: 0 0.25rem;
        }

        .nav-link:hover {
            background-color: rgba(79, 70, 229, 0.2);
            transform: translateY(-2px);
            color: #4338ca;
        }

        .nav-link.active {
            background-color: #4f46e5;
            color: white;
        }

        .footer-link {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            background-color: rgba(107, 114, 128, 0.1);
            color: #6b7280;
        }

        .footer-link:hover {
            background-color: rgba(79, 70, 229, 0.2);
            color: #4f46e5;
            transform: translateY(-2px);
        }

        .brand-link {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4f46e5;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .brand-link:hover {
            background-color: rgba(79, 70, 229, 0.1);
            color: #4338ca;
        }

        .logout-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: none;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: rgba(239, 68, 68, 0.2);
            color: #dc2626;
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-light">
    {{-- Header --}}
    <header class="bg-white shadow-sm sticky-top">
        <div class="container-fluid py-3">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('home') }}" class="brand-link">
                    Universidade Save
                </a>

                <nav class="d-flex align-items-center gap-2">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Início</a>
                    @auth
                        @if(auth()->user()->role === 'community')
                            <a href="{{ route('enrollments.my') }}" class="nav-link {{ request()->routeIs('enrollments.my') ? 'active' : '' }}">Minhas Inscrições</a>
                        @endif
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'coordinator')
                            <a href="{{ route('projects.manage') }}" class="nav-link {{ request()->routeIs('projects.manage') ? 'active' : '' }}">Projetos</a>
                            <a href="{{ route('activities.manage') }}" class="nav-link {{ request()->routeIs('activities.manage') ? 'active' : '' }}">Atividades</a>
                        @endif
                        <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">Perfil</a>
                        <form method="POST" action="" class="d-inline">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="bi bi-box-arrow-right me-1"></i>Sair
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Entrar</a>
                        <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">Registrar</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    {{-- Conteúdo Principal --}}
    <main class="py-4">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-light py-4 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0">&copy; {{ date('Y') }} Universidade Save. Todos os direitos reservados.</p>
                </div>
                <div class="col-12 col-md-6 text-center text-md-end">
                    <a href="#" class="footer-link">
                        <i class="bi bi-facebook me-1"></i>Facebook
                    </a>
                    <a href="#" class="footer-link">
                        <i class="bi bi-instagram me-1"></i>Instagram
                    </a>
                    <a href="#" class="footer-link">
                        <i class="bi bi-linkedin me-1"></i>LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
