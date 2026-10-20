<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Fila de Moderação — {{ $evento->titulo }}</h2>
    </x-slot>
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-sm sm:rounded-lg space-y-4">
            @if(session('sucesso'))<p class="text-green-700">{{ session('sucesso') }}</p>@endif
            @forelse($moderacoes as $moderacao)
                <div class="border rounded p-4">
                    <p class="font-semibold">Pergunta: {{ $moderacao->pergunta->texto ?? 'Pergunta indisponível' }}</p>
                    <p class="mt-2">Motivo: {{ $moderacao->motivo }}</p>
                    <p class="text-sm text-gray-600">Status: {{ $moderacao->status }}</p>
                    @if($moderacao->status === 'analisando')
                        <div class="flex gap-3 mt-3">
                            @foreach(['aprovada' => 'Aprovar', 'rejeitada' => 'Rejeitar'] as $status => $label)
                                <form method="POST" action="{{ route('moderacoes.status', $moderacao) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $status }}">
                                    <button class="px-3 py-2 rounded bg-indigo-600 text-white" type="submit">{{ $label }}</button>
                                </form>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-600">Não há denúncias para este evento.</p>
            @endforelse
            {{ $moderacoes->links() }}
        </div>
    </div>
</x-app-layout>
