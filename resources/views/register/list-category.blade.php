@extends('system')

@section('title', 'Categorias de Produtos' )
@section('page_title', 'Categoria de Produtos')

@section('top_actions')
  <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
    Criar
  </a>
@endsection

@section('content')
  <div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <form method="GET" action="{{ route('categories.index') }}" class="flex items-center space-x-2">
        <label for="q" class="sr-only">Buscar</label>
        <input id="q" name="q" value="{{ request('q') }}" type="search" placeholder="Buscar por nome"
               class="block w-64 rounded-md border border-gray-300 bg-white py-2 px-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
        <button type="submit" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm">
          Buscar
        </button>
        <button type="button" onclick="window.location='{{ route('categories.index') }}'" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm">
          Limpar
        </button>
      </form>
    </div>
  </div>

  <div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      @if($categorys->count())
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criado em</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
          </thead>

          @php
            $start = method_exists($categorys, 'firstItem') && $categorys->firstItem() ? $categorys->firstItem() : 1;
          @endphp

          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($categorys as $index => $category)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ $start + $index }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->name }}</td>

                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ optional($category->created_at)->format('d/m/Y H:i') ?? '—' }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                  <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-400 hover:text-blue-200">Editar</a>
                  <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="p-6 text-center text-gray-600">
          Nenhum produto encontrado.
        </div>
      @endif
    </div>

    @if(method_exists($categorys, 'links'))
      <div class="px-4 py-3 bg-white border-t border-gray-100 sm:px-6">
        <div class="flex items-center justify-between">
          <div class="text-sm text-gray-700">
            Mostrando <span class="font-medium">{{ $categorys->firstItem() ?? 0 }}</span> até <span class="font-medium">{{ $categorys->lastItem() ?? 0 }}</span> de <span class="font-medium">{{ $categorys->total() ?? $categorys->count() }}</span>
          </div>
          <div>
            {{ $categorys->appends(request()->only('q'))->links() }}
          </div>
        </div>
      </div>
    @endif
  </div>
@endsection
