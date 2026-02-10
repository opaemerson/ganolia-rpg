@extends('system')

@section('title', 'Compras')
@section('page_title', 'Compras')

@section('top_actions')
  <a href="{{ route('purchases.create') }}" 
     class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700">
    Nova Compra
  </a>
@endsection

@section('content')
  <div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      @if($purchases->count())
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fornecedor</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($purchases as $purchase)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-900">{{ $purchase->id }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $purchase->supplier->name ?? '—' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">R$ {{ number_format($purchase->total, 2, ',', '.') }}</td>
                <td class="px-6 py-4 text-sm">
                  <span class="px-2 py-1 rounded text-xs font-medium 
                    @if($purchase->status === 'Confirmado') bg-green-100 text-green-800 
                    @elseif($purchase->status === 'Cancelado') bg-red-100 text-red-800 
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ ucfirst($purchase->status) }}
                  </span>
                </td>
                <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                  <a href="{{ route('purchases.show', $purchase->id) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                  <a href="{{ route('purchases.edit', $purchase->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                  <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Excluir esta compra?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="p-6 text-center text-gray-600">Nenhuma compra encontrada.</div>
      @endif
    </div>
    {{ $purchases->links() }}
  </div>
@endsection
