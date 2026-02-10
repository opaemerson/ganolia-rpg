@extends('system')

@section('title', 'Criar Produto')
@section('page_title', 'Criar Produto')

@section('top_actions')
  <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md shadow-sm hover:bg-gray-300">
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

    <form action="{{ route('products.store') }}" method="POST" class="space-y-6 bg-white p-8 rounded-lg shadow-lg">
      @csrf

      <h2 class="text-lg font-semibold text-gray-900">Informações do produto</h2>
      <p class="text-sm text-gray-500">Preencha o nome do produto abaixo.</p>

      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
               class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
        @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>
      
      <div>
        <label for="cost_price" class="block text-sm font-medium text-gray-700">Preço de Custo</label>
        <input id="cost_price" name="cost_price" type="text" value="{{ old('cost_price') }}" required
              class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm" />
        @error('cost_price') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="sale_price" class="block text-sm font-medium text-gray-700">Preço de Venda</label>
        <input id="sale_price" name="sale_price" type="text" value="{{ old('sale_price') }}" required
              class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm" />
        @error('sale_price') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700">Categoria</label>
        <select id="category_id" name="category_id" required
                class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
        @error('category_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div class="flex items-center justify-between pt-4 border-t border-gray-100">
        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
          Cancelar
        </a>

        <button type="submit" class="inline-flex items-center px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Criar Produto
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  function toNumberString(pt) {
    if (!pt) return '';
    return pt.toString().replace(/\s|R\$|r\$/g, '').replace(/\./g, '').replace(/,/g, '.');
  }

  function formatPt(value) {
    if (value === '' || isNaN(Number(value))) return '';
    return new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(Number(value));
  }

  ['cost_price','sale_price'].forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;

    // ao focar: mostra valor "limpo" para editar
    el.addEventListener('focus', () => {
      el.value = toNumberString(el.value);
    });

    // ao sair: formata pt-BR
    el.addEventListener('blur', () => {
      el.value = formatPt(toNumberString(el.value));
    });

    // inicializa formatado se já houver valor
    if (el.value) el.value = formatPt(toNumberString(el.value));
  });
});
</script>

@endpush