@extends('system')

@section('title', 'Criar Perfil')
@section('page_title', 'Criar Perfil')

@section('top_actions')
    <a href="{{ route('profiles.index') }}"
        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md shadow-sm hover:bg-gray-300">
        Voltar
    </a>
@endsection

@section('content')
    <div class="max-w-xl mx-auto">
        <form action="{{ route('profiles.store') }}" method="POST" class="space-y-6 bg-white p-8 rounded-lg shadow-lg">
            @csrf

            <h2 class="text-lg font-semibold text-gray-900">Informações do Perfil</h2>
            <p class="text-sm text-gray-500">Preencha o nome do perfil abaixo.</p>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <a href="{{ route('profiles.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancelar
                </a>

                <button type="submit"
                    class="inline-flex items-center px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Criar Perfil
                </button>
            </div>
        </form>
    </div>
@endsection