<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Permissão antes de todos os métodos (Super User).
     * O administrador pode fazer TUDO.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    /**
     * Determina se o usuário pode ver QUALQUER projeto (listagem).
     */
   public function viewAny(User $user): bool
    {
        // Apenas Administradores e Coordenadores podem acessar a listagem de gestão.
        return in_array($user->role, ['admin', 'coordinator']);
    }

    /**
     * Determina se o usuário pode ver um projeto específico.
     * 1. Se estiver publicado, qualquer um vê.
     * 2. Se for rascunho, só o admin ou o coordenador responsável.
     */
  public function view(User $user, Project $project): bool
    {
        // Se o projeto estiver publicado, todos (incluindo 'community') podem ver.
        if ($project->status === 'published') {
            return true;
        }

        // Se for rascunho ('draft'), só o coordenador ou admin (coordenador já é coberto pelo before).
        return $user->id === $project->coordinator_id;
    }

    /**
     * Determina se o usuário pode criar projetos.
     */
    public function create(User $user): bool
    {
        // Apenas Coordenadores e Administradores (coberto pelo before) podem criar.
        return $user->role === 'coordinator';
    }

    /**
     * Determina se o usuário pode atualizar (editar) o projeto.
     */
    public function update(User $user, Project $project): bool
    {
        // Apenas o Coordenador que criou/coordena o projeto pode editá-lo.
        return $user->id === $project->coordinator_id;
    }

    /**
     * Determina se o usuário pode deletar o projeto.
     */
    public function delete(User $user, Project $project): bool
    {
        // Apenas o Coordenador que coordena o projeto pode deletá-lo.
        return $user->id === $project->coordinator_id;
    }
}
