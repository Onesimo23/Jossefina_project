<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">

        <!-- Email -->
        <div class="group">
            <x-input-label for="email" value="Email" class="text-gray-700 font-medium mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input
                    wire:model="form.email"
                    id="email"
                    class="block w-full pl-10 pr-4 py-3 rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                    type="email"
                    placeholder="seu@email.com"
                    required />
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="group">
            <x-input-label for="password" value="Senha" class="text-gray-700 font-medium mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input
                    wire:model="form.password"
                    id="password"
                    class="block w-full pl-10 pr-4 py-3 rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                    type="password"
                    placeholder="••••••••"
                    required />
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center cursor-pointer group">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 focus:ring-offset-0 transition-colors cursor-pointer">
                <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Lembrar-me</span>
            </label>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" wire:navigate
                class="text-sm text-purple-600 hover:text-purple-700 font-medium transition-colors">
                Esqueceu a senha?
            </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center space-x-2">
            <span>Entrar</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </button>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500">ou</span>
            </div>
        </div>

        <!-- Social Login (Optional - Remove if not needed) -->
        <div class="grid grid-cols-2 gap-3">
            <button type="button"
                class="flex items-center justify-center space-x-2 px-4 py-2.5 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                <svg class="h-5 w-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-sm font-medium text-gray-700">Google</span>
            </button>

            <button type="button"
                class="flex items-center justify-center space-x-2 px-4 py-2.5 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                <svg class="h-5 w-5" fill="#1877F2" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                <span class="text-sm font-medium text-gray-700">Facebook</span>
            </button>
        </div>

    </form>

    <!-- Register Link -->
    <div class="mt-8 text-center">
        <p class="text-sm text-gray-600">
            Não tem uma conta?
            <a href="{{ route('register') }}" wire:navigate
                class="text-purple-600 hover:text-purple-700 font-semibold transition-colors">
                Criar conta gratuita
            </a>
        </p>
    </div>

    <!-- Terms & Privacy (Optional) -->
    <div class="mt-6 text-center">
        <p class="text-xs text-gray-500">
            Ao continuar, você concorda com nossos
            <a href="#" class="text-purple-600 hover:underline">Termos de Uso</a>
            e
            <a href="#" class="text-purple-600 hover:underline">Política de Privacidade</a>
        </p>
    </div>
</div>
