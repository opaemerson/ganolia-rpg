@extends('system')

@section('title', 'Venda')
@section('page_title', 'Detalhes da Venda')

@section('top_actions')
  <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">Voltar</a>
@endsection

@section('content')
  <div class="bg-white shadow-sm rounded-lg p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Cliente: {{ $sale->client->name ?? '—' }}</h2>

    <p class="mb-2"><strong>Status:</strong> {{ $sale->status }}</p>
    <p class="mb-2"><strong>Total:</strong> R$ {{ number_format($sale->total, 2, ',', '.') }}</p>

    <h3 class="text-md font-medium text-gray-800 mt-6 mb-2">Itens</h3>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produto</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Qtd</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Preço</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($sale->items as $item)
          <tr>
            <td class="px-4 py-2 text-sm">{{ $item->product->name ?? '—' }}</td>
            <td class="px-4 py-2 text-sm">{{ $item->quantity }}</td>
            <td class="px-4 py-2 text-sm">R$ {{ number_format($item->sale_price, 2, ',', '.') }}</td>
            <td class="px-4 py-2 text-sm">R$ {{ number_format($item->total, 2, ',', '.') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-6 flex space-x-3">
      @if($sale->status === \App\Models\Sale::STATUS_OPEN)
        <form action="{{ route('sales.confirm', $sale->id) }}" method="POST">
          @csrf
          <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Confirmar (Vender)</button>
        </form>
        <form action="{{ route('sales.cancel', $sale->id) }}" method="POST">
          @csrf
          <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Cancelar e Restaurar Estoque</button>
        </form>
        <a href="{{ route('sales.index') }}"
          class="inline-flex items-center px-4 py-2 
                  bg-gray-100 text-gray-700 
                  border border-gray-300
                  rounded-md hover:bg-gray-200">
          Deixar em aberto
        </a>
      @endif
    </div>
  </div>
@endsection
