@extends('system')

@section('title', 'Vendas')
@section('page_title', 'Vendas')

@section('top_actions')
  <a href="{{ route('sales.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md">Nova Venda</a>
@endsection

@section('content')
  <div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      @if($sales->count())
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($sales as $sale)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-900">{{ $sale->id }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $sale->client->name ?? '—' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                <td class="px-6 py-4 text-sm">
                  <span class="px-2 py-1 rounded text-xs font-medium
                    @if($sale->status === $sale::STATUS_PAID) bg-green-100 text-green-800
                    @elseif($sale->status === $sale::STATUS_CANCELED) bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ $sale->status }}
                  </span>
                </td>
                <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                  <a href="{{ route('sales.show', $sale->id) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                  <a href="{{ route('sales.edit', $sale->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                  <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Excluir esta venda?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="p-6 text-center text-gray-600">Nenhuma venda encontrada.</div>
      @endif
    </div>

    <div class="px-4 py-3 bg-white border-t border-gray-100 sm:px-6">
      {{ $sales->links() }}
    </div>
  </div>
@endsection
