@extends('system')

@section('title', 'Editar Categoria de Produto')
@section('page_title', 'Editar Categoria de Produto')

@section('top_actions')
  <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md shadow-sm hover:bg-gray-300">
    Voltar
  </a>
@endsection

@section('content')
  <div class="max-w-xl mx-auto">
    @if(session('success'))
      <div class="mb-6 rounded-md bg-green-50 p-4">
        <p class="text-sm text-green-700">{{ session('success') }}</p>
      </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-6 bg-white p-8 rounded-lg shadow-lg">
      @csrf
      @method('PUT')

      <h2 class="text-lg font-semibold text-gray-900">Editar Categoria de Produto</h2>
      <p class="text-sm text-gray-500">Atualize os dados da Categoria de Produto abaixo.</p>

      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
        <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" required autofocus
               class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
        @error('name') 
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
        @enderror
      </div>

      <div class="flex items-center justify-between pt-4 border-t border-gray-100">
        <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
          Cancelar
        </a>

        <div class="flex items-center space-x-3">
          <button type="submit" class="inline-flex items-center px-5 py-2 bg-green-600 text-white text-sm font-semibold rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            Salvar Alterações
          </button>
        </div>
      </div>
    </form>
  </div>
@endsection
