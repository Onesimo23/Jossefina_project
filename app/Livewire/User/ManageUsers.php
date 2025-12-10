<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class ManageUsers extends Component {
    use WithPagination;

    public $search = '';
    public $modalOpen = false;
    public $confirmDeleteOpen = false;

    public $userId, $name, $email, $password, $role = 'community';

    public function openModal($id = null) {
        $this->resetValidation();
        $this->reset(['userId', 'name', 'email', 'password', 'role']);

        if ($id) {
            $user = User::findOrFail($id);

            $this->userId = $id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->role;
        }

        $this->modalOpen = true;
    }

    public function save() {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|in:admin,coordinator,community',
            'password' => $this->userId ? 'nullable|min:6' : 'required|min:6',
        ]);

        if ($this->userId) {

            // EDIÇÃO
            $user = User::findOrFail($this->userId);

            if ($this->password) {
                $validated['password'] = Hash::make($this->password);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);
        } else {

            $validated['password'] = Hash::make($this->password);
            User::create($validated);
        }

        session()->flash('message', 'Usuário salvo com sucesso!');
        $this->modalOpen = false;
    }

    public function confirmDelete($id) {
        $this->userId = $id;
        $this->confirmDeleteOpen = true;
    }

    public function delete() {
        User::findOrFail($this->userId)->delete();
        $this->confirmDeleteOpen = false;
        session()->flash('message', 'Usuário removido!');
    }

    public function render() {
        $users = User::where('name', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%")
            ->paginate(10);

        return view('livewire.user.manage-users', compact('users'))->layout('layouts.app');
    }
}
