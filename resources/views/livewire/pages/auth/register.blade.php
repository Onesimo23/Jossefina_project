<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    // Campos existentes
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // NOVO CAMPO para capturar a intenção de role
    // O valor padrão agora é uma string vazia para forçar o usuário a escolher
    public string $intended_role = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            // O campo 'intended_role' agora é implicitamente validado como 'required' e
            // deve ser um dos valores permitidos.
            'intended_role' => ['required', 'in:community,coordinator,admin'],
        ]);

        // ----------------------------------------------------------------------------------
        // MODO DE TESTE/DEV:
        // A role REAL agora é definida pela seleção do usuário ($this->intended_role).
        // ----------------------------------------------------------------------------------
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = $this->intended_role; // AGORA USA A ROLE ESCOLHIDA

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- NOVO CAMPO: Nível de Acesso (Role) -->
        <div class="mt-4">
            <x-input-label for="intended_role" value="Qual o seu nível de acesso?" />
            <select wire:model="intended_role" id="intended_role" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                <!-- NOVA OPÇÃO DE PLACEHOLDER -->
                <option value="" disabled>-- Escolha o seu nível de acesso --</option>
                <option value="community">Comunidade/Usuário Padrão</option>
                <option value="coordinator">Coordenador de Projeto</option>
                <option value="admin">Administrador </option>
            </select>
            <!-- AVISO: EM MODO DE TESTE/DEV, a role escolhida é aplicada diretamente. -->
            <x-input-error :messages="$errors->get('intended_role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
