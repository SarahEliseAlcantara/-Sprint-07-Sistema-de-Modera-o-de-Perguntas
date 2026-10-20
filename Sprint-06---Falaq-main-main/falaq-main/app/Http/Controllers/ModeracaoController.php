<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModeracaoRequest;
use App\Models\Evento;
use App\Models\Moderacao;
use App\Models\Pergunta;
use Illuminate\Http\Request;

class ModeracaoController extends Controller
{
    public function store(StoreModeracaoRequest $request, Pergunta $pergunta)
    {
        $pergunta->moderacoes()->create([
            'motivo' => $request->validated()['motivo'],
            'status' => 'analisando',
        ]);

        return back()->with('sucesso', 'Denúncia enviada para análise.');
    }

    public function index(Evento $evento)
    {
        $this->authorize('moderate', $evento);

        $moderacoes = Moderacao::with('pergunta')
            ->whereHas('pergunta', fn ($query) => $query->where('evento_id', $evento->id))
            ->latest()
            ->paginate(15);

        return view('moderacoes.index', compact('evento', 'moderacoes'));
    }

    public function updateStatus(Request $request, Moderacao $moderacao)
    {
        $pergunta = $moderacao->pergunta;
        abort_unless($pergunta, 404);
        $evento = $pergunta->evento;
        abort_unless($evento, 404);
        $this->authorize('moderate', $evento);

        $dados = $request->validate([
            'status' => ['required', 'in:aprovada,rejeitada'],
        ]);

        $moderacao->update(['status' => $dados['status']]);
        $pergunta->update(['status' => $dados['status']]);

        return back()->with('sucesso', 'Decisão de moderação salva.');
    }
}
