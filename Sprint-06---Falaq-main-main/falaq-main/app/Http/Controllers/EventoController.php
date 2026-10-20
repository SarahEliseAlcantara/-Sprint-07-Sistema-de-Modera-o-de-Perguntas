<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Pergunta;
use App\Http\Requests\StorePerguntaRequest;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::all();
        return view('eventos.index', compact('eventos'));
    }

    /**
     * TICKET #012 (Ranking de Votos no Telão) + Histórico de Tickets anteriores:
     * Carrega as perguntas do evento com eager loading do 'user', calcula a
     * contagem de votos virtuais via 'withCount' e ordena de forma decrescente.
     */
    public function show($id)
    {
        $evento = Evento::findOrFail($id);

        // Combina o filtro do evento, eager loading do usuário, contagem de votos e ordenação do Ticket #012
        $perguntas = Pergunta::where('evento_id', $evento->id)
            ->with('user')
            ->withCount('votos')
            ->orderByDesc('votos_count')
            ->paginate(10);

        return view('eventos.show', compact('evento', 'perguntas'));
    }

    /**
     * TICKET #011 (Rota de Voto com Alternância via toggle)
     */
    public function votar(Pergunta $pergunta)
    {
        // O método toggle adiciona o voto se não existir, ou remove se já existir
        $pergunta->votos()->toggle(auth()->id());

        return back()->with('sucesso', 'Seu voto foi processado com sucesso!');
    }

    /**
     * TICKET #001 (BUG LEGADO DE SEGURANÇA):
     * Salva a pergunta usando a requisição sem validações rigorosas.
     */
    public function storePergunta(StorePerguntaRequest $request, $id)
    {
        $evento = Evento::findOrFail($id);

        Pergunta::create([
            'evento_id' => $evento->id,
            'texto'     => $request->input('texto'),
            'status'    => 'pendente',
        ]);

        return redirect()->route('eventos.show', $evento->id)
            ->with('sucesso', 'Sua pergunta foi enviada com sucesso!');
    }

    public function create()
    {
        return view('eventos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
        ]);

        Evento::create([
            'titulo' => $request->input('titulo'),
            'descricao' => $request->input('descricao'),
            'data_evento' => $request->input('data_evento'),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('eventos.index');
    }
}
