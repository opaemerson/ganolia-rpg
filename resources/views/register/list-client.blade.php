@extends('system')

@section('title', 'Clientes')
@section('page_title', 'Clientes')

@section('top_actions')
  <div class="flex items-center space-x-2">
    <a href="{{ route('clients.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
      Novo Cliente
    </a>
  </div>
@endsection

@section('content')
  <div class="max-w-7xl mx-auto">
    @if(session('success'))
      <div class="mb-4 rounded-md bg-green-50 p-4">
        <p class="text-sm text-green-700">{{ session('success') }}</p>
      </div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <p class="text-sm text-gray-600">Lista de clientes cadastrados no sistema.</p>

      <form method="GET" action="{{ route('clients.index') }}" class="flex items-center space-x-2">
        <label for="q" class="sr-only">Buscar</label>
        <input id="q" name="q" value="{{ request('q') }}" type="search" placeholder="Buscar por nome ou documento"
               class="block w-64 rounded-md border border-gray-300 bg-white py-2 px-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
        <button type="submit" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm">
          Buscar
        </button>
      </form>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
      @php
        $start = method_exists($clients, 'firstItem') && $clients->firstItem() ? $clients->firstItem() : 1;
      @endphp

      @if($clients->count())
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documento</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-mail</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
              </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($clients as $index => $client)
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $start + $index }}</td>

                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ $client->name }}
                  </td>

                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $client->document }}
                  </td>

                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $client->phones->first()?->phone ?? '—' }}
                  </td>

                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $client->emails->first()?->email ?? '—' }}
                  </td>

                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                    <a href="{{ route('clients.edit', $client) }}" class="text-indigo-600 hover:text-indigo-800">Editar</a>

                    <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @if(method_exists($clients, 'links'))
          <div class="px-4 py-3 bg-white border-t border-gray-100 sm:px-6">
            <div class="flex items-center justify-between">
              <div class="text-sm text-gray-700">
                Mostrando <span class="font-medium">{{ $clients->firstItem() ?? 0 }}</span> até <span class="font-medium">{{ $clients->lastItem() ?? 0 }}</span> de <span class="font-medium">{{ $clients->total() ?? $clients->count() }}</span>
              </div>
              <div>
                {{ $clients->appends(request()->only('q'))->links() }}
              </div>
            </div>
          </div>
        @else
          <div class="p-4 text-sm text-gray-600">
            Mostrando {{ $clients->count() }} clientes.
          </div>
        @endif

      @else
        <div class="p-8 text-center">
          <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a8 8 0 11-16 0 8 8 0 0116 0z" />
          </svg>
          <h3 class="mt-4 text-lg font-medium text-gray-900">Nenhum cliente encontrado</h3>
          <p class="mt-2 text-sm text-gray-500">Você ainda não tem clientes cadastrados ou a busca não retornou resultados.</p>
          <div class="mt-6">
            <a href="{{ route('clients.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700">
              Criar primeiro cliente
            </a>
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection
