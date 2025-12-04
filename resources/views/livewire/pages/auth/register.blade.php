<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.guest')] class extends Component
{
    use WithFileUploads;

    // Campos existentes
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Novo campo para foto de perfil
    public $profile_photo;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'community'; // Sempre registra como community

        // Salva a imagem se foi enviada
        if ($this->profile_photo) {
            $validated['profile_photo_path'] = $this->profile_photo->store('profile-photos', 'public');
        }

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register" class="space-y-5" enctype="multipart/form-data">

        <!-- Name -->
        <div class="group">
            <x-input-label for="name" value="Nome completo" class="text-gray-700 font-medium mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-text-input
                    wire:model="name"
                    id="name"
                    class="block w-full pl-10 pr-4 py-3 rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                    type="text"
                    placeholder="Joan Gina"
                    required
                    autofocus />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="group">
            <x-input-label for="email" value="Email" class="text-gray-700 font-medium mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input
                    wire:model="email"
                    id="email"
                    class="block w-full pl-10 pr-4 py-3 rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                    type="email"
                    placeholder="seu@email.com"
                    required />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
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
                    wire:model="password"
                    id="password"
                    class="block w-full pl-10 pr-4 py-3 rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                    type="password"
                    placeholder="••••••••"
                    required />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="group">
            <x-input-label for="password_confirmation" value="Confirmar senha" class="text-gray-700 font-medium mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <x-text-input
                    wire:model="password_confirmation"
                    id="password_confirmation"
                    class="block w-full pl-10 pr-4 py-3 rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                    type="password"
                    placeholder="••••••••"
                    required />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Campo de upload de foto de perfil -->
        <div class="group">
            <x-input-label for="profile_photo" value="Foto de perfil (opcional)" class="text-gray-700 font-medium mb-2" />
            <input
                wire:model="profile_photo"
                id="profile_photo"
                name="profile_photo"
                type="file"
                class="block w-full pl-3 pr-4 py-3 rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                accept="image/*"
            />
            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />

            @if ($profile_photo)
                <div class="mt-2">
                    <span class="text-sm text-gray-500">Pré-visualização:</span>
                    <img src="{{ $profile_photo->temporaryUrl() }}" class="w-20 h-20 rounded-full mt-2 object-cover">
                </div>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center space-x-2 mt-6">
            <span>Criar conta</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </button>

    </form>

    <!-- Login Link -->
    <div class="mt-8 text-center">
        <p class="text-sm text-gray-600">
            Já tem uma conta?
            <a href="{{ route('login') }}" wire:navigate
                class="text-purple-600 hover:text-purple-700 font-semibold transition-colors">
                Fazer login
            </a>
        </p>
    </div>

    <!-- Terms & Privacy -->
    <div class="mt-6 text-center">
        <p class="text-xs text-gray-500">
            Ao criar uma conta, você concorda com nossos
            <a href="#" class="text-purple-600 hover:underline">Termos de Uso</a>
            e
            <a href="#" class="text-purple-600 hover:underline">Política de Privacidade</a>
        </p>
    </div>
</div>
