<?php

namespace App\Policies;

use App\Models\Pergunta;
use App\Models\User;

class PerguntaPolicy
{
    /**
     * Determina se o usuário pode deletar a pergunta.
     */
    public function delete(User $user, Pergunta $pergunta): bool
    {
        // Regra: Pode deletar se for o autor da pergunta OU o dono do evento
        return $user->id === $pergunta->user_id || $user->id === $pergunta->evento->user_id;
    }
}
