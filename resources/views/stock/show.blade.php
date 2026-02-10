@extends('system')

@section('title', 'Estoque')
@section('page_title', 'Detalhes do Estoque')

@section('top_actions')
  <a href="{{ route('stocks.index') }}" 
     class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
    Voltar
  </a>
@endsection

@section('content')
  <div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900 mb-4">
        Produto: {{ $stock->product->name ?? '—' }}
      </h2>

      <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
        <div>
          <dt class="text-sm font-medium text-gray-500">Quantidade Atual</dt>
          <dd class="mt-1 text-sm text-gray-900">{{ $stock->quantity }}</dd>
        </div>

        <div>
          <dt class="text-sm font-medium text-gray-500">Última Atualização</dt>
          <dd class="mt-1 text-sm text-gray-900">
            {{ optional($stock->updated_at)->format('d/m/Y H:i') ?? '—' }}
          </dd>
        </div>

        <div>
          <dt class="text-sm font-medium text-gray-500">Criado em</dt>
          <dd class="mt-1 text-sm text-gray-900">
            {{ optional($stock->created_at)->format('d/m/Y H:i') ?? '—' }}
          </dd>
        </div>
      </dl>
    </div>
  </div>
@endsection
