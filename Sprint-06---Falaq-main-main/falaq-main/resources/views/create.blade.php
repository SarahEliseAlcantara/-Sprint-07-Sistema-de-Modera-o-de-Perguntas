@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Criar Novo Evento</h1>

    <form action="{{ route('eventos.store') }}" method="POST">
        @csrf

        {{-- Campo Título --}}
        <div class="mb-4">
            <label for="titulo" class="block text-gray-700 font-medium mb-2">Título do Evento</label>
            <input 
                type="text" 
                name="titulo" 
                id="titulo" 
                value="{{ old('titulo') }}"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titulo') border-red-500 @else border-gray-300 @enderror"
                placeholder="Digite o título do evento"
            >
            @error('titulo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Campo Descrição --}}
        <div class="mb-6">
            <label for="descricao" class="block text-gray-700 font-medium mb-2">Descrição</label>
            <textarea 
                name="descricao" 
                id="descricao" 
                rows="4" 
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descricao') border-red-500 @else border-gray-300 @enderror"
                placeholder="Descreva os detalhes do evento"
            >{{ old('descricao') }}</textarea>
            @error('descricao')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botão de Envio --}}
        <div class="flex justify-end">
            <button 
                type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200"
            >
                Cadastrar Evento
            </button>
        </div>
    </form>
</div>
@endsection