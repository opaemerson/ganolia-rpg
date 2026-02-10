@extends('system')

@section('title', 'Estoque')
@section('page_title', 'Estoque')

@section('top_actions')
  <!-- Nenhuma ação de criação/edição manual -->
@endsection

@section('content')
  <div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <form method="GET" action="{{ route('stock.index') }}" class="flex items-center space-x-2">
        <label for="search" class="sr-only">Buscar</label>
        <input id="search" name="search" value="{{ request('search') }}" type="search" placeholder="Buscar por produto"
               class="block w-64 rounded-md border border-gray-300 bg-white py-2 px-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
        <button type="submit" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm">
          Buscar
        </button>
        <a href="{{ route('stock.index') }}" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm">
          Limpar
        </a>
      </form>
    </div>
  </div>

  <div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      @if($stocks->count())
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade Atual</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Atualizado em</th>
            </tr>
          </thead>

          @php
            $start = method_exists($stocks, 'firstItem') && $stocks->firstItem() ? $stocks->firstItem() : 1;
          @endphp

          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($stocks as $index => $stock)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ $start + $index }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ $stock->product->name ?? '—' }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $stock->quantity }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ optional($stock->updated_at)->format('d/m/Y H:i') ?? '—' }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="p-6 text-center text-gray-600">
          Nenhum registro de estoque encontrado.
        </div>
      @endif
    </div>

    @if(method_exists($stocks, 'links'))
      <div class="px-4 py-3 bg-white border-t border-gray-100 sm:px-6">
        <div class="flex items-center justify-between">
          <div class="text-sm text-gray-700">
            Mostrando <span class="font-medium">{{ $stocks->firstItem() ?? 0 }}</span> até <span class="font-medium">{{ $stocks->lastItem() ?? 0 }}</span> de <span class="font-medium">{{ $stocks->total() ?? $stocks->count() }}</span>
          </div>
          <div>
            {{ $stocks->appends(request()->only('search'))->links() }}
          </div>
        </div>
      </div>
    @endif
  </div>
@endsection
