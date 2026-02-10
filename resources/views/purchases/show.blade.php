@extends('system')

@section('title', 'Compra')
@section('page_title', 'Detalhes da Compra')

@section('top_actions')
  <a href="{{ route('purchases.index') }}"
     class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
    Voltar
  </a>
@endsection

@section('content')
  <div class="bg-white shadow-sm rounded-lg p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">
      Fornecedor: {{ $purchase->supplier->name ?? '—' }}
    </h2>

    <p class="mb-2"><strong>Status:</strong> {{ ucfirst($purchase->status) }}</p>
    <p class="mb-2"><strong>Total:</strong>
      R$ {{ number_format($purchase->total, 2, ',', '.') }}
    </p>

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
        @foreach($purchase->items as $item)
          @php
            $subtotal = $item->quantity * $item->cost_price;
          @endphp
          <tr>
            <td class="px-4 py-2 text-sm">{{ $item->product->name }}</td>
            <td class="px-4 py-2 text-sm">{{ $item->quantity }}</td>
            <td class="px-4 py-2 text-sm">
              R$ {{ number_format($item->cost_price, 2, ',', '.') }}
            </td>
            <td class="px-4 py-2 text-sm">
              R$ {{ number_format($subtotal, 2, ',', '.') }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    @php
      $total = $purchase->items->sum(fn ($item) => $item->quantity * $item->cost_price);
    @endphp

    <div class="mt-6 text-right">
      <div class="text-sm text-gray-700">Total da Compra</div>
      <div class="text-lg font-medium text-gray-900">
        R$ {{ number_format($total, 2, ',', '.') }}
      </div>
    </div>

    {{-- AÇÕES --}}
    <div class="mt-6 flex space-x-3">
      @if($purchase->status === \App\Models\Purchase::STATUS_OPEN)
        <form action="{{ route('purchases.confirm', $purchase->id) }}" method="POST">
          @csrf
          <button
            type="submit"
            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
            Confirmar
          </button>
        </form>

        <form action="{{ route('purchases.cancel', $purchase->id) }}" method="POST">
          @csrf
          <button
            type="submit"
            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
            Cancelar
          </button>
        </form>
        <a href="{{ route('purchases.index') }}"
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
