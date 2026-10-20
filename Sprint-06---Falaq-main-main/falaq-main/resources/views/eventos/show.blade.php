<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $evento->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <p class="text-gray-600 text-sm">Criado por: {{ $evento->user->name ?? 'Anônimo' }}</p>
                    <p class="mt-4 text-gray-700">{{ $evento->descricao }}</p>
                </div>

                <hr class="my-6">

                <h3 class="font-semibold text-lg text-gray-800 mb-4">Perguntas</h3>

                <div class="mt-4 space-y-4">
                    {{-- Alterado de $evento->perguntas para $perguntas para respeitar a paginação do Controller --}}
                    @forelse($perguntas as $pergunta)
                        <div class="bg-gray-50 p-4 rounded-lg flex justify-between items-center border border-gray-100 shadow-sm">
                            <div>
                                {{-- Ajustado para o nome correto do campo enviado na migração ou banco (texto/conteudo) --}}
                                <p class="text-gray-800 font-medium">{{ $pergunta->texto ?? $pergunta->conteudo }}</p>
                                <p class="text-xs text-gray-500 mt-1">Por: {{ $pergunta->user->name ?? 'Anônimo' }}</p>
                                @auth
                                    <form action="{{ route('moderacoes.store', $pergunta) }}" method="POST" class="mt-3">
                                        @csrf
                                        <label class="block text-xs text-gray-600 mb-1">Denunciar pergunta</label>
                                        <input name="motivo" maxlength="255" minlength="10" required class="w-full text-sm rounded border-gray-300" placeholder="Explique o motivo (10 a 255 caracteres)">
                                        <button type="submit" class="mt-2 text-xs px-3 py-1 rounded border border-red-500 text-red-600">Enviar denúncia</button>
                                    </form>
                                @endauth
                            </div>

                            <div class="flex items-center space-x-4">
                                {{-- Ticket #012: UI de Votos e Contador Virtual --}}
                                <div class="flex flex-col items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800 mb-1">
                                        {{ $pergunta->votos_count ?? 0 }} {{ Str::plural('voto', $pergunta->votos_count ?? 0) }}
                                    </span>

                                    @auth
                                        <form action="{{ route('perguntas.votar', $pergunta) }}" method="POST">
                                            @csrf
                                            @php
                                                $jaVotou = $pergunta->votos->contains(auth()->id());
                                            @endphp

                                            @if($jaVotou)
                                                {{-- Botão destacado indicando que o próximo clique removerá o voto --}}
                                                <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-semibold rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    ▲ Votado
                                                </button>
                                            @else
                                                {{-- Botão padrão para dar Upvote --}}
                                                <button type="submit" class="inline-flex items-center px-3 py-1 border border-indigo-600 text-xs font-semibold rounded-md text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    ▲ Votar
                                                </button>
                                            @endif
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">Logue para votar</span>
                                    @endauth
                                </div>

                                {{-- Botão legado de exclusão --}}
                                @can('delete', $pergunta)
                                    <form action="{{ route('perguntas.destroy', $pergunta) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta pergunta?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button>Excluir</x-danger-button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm italic">Nenhuma pergunta enviada para este evento ainda.</p>
                    @endforelse
                </div>

                {{-- Links de Paginação renderizados de 10 em 10 --}}
                <div class="mt-4">
                    {{ $perguntas->links() }}
                </div>

                <div class="mt-8">
                    <h4 class="font-semibold text-md text-gray-800 mb-2">Faça uma Pergunta</h4>
                    <form action="{{ route('perguntas.store', $evento) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <textarea name="texto" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Digite sua pergunta aqui..." required></textarea>
                        </div>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Enviar Pergunta
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
