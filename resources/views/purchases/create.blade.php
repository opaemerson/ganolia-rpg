@extends('system')

@section('title', 'Nova Compra')
@section('page_title', 'Nova Compra')

@section('top_actions')
  <a href="{{ route('purchases.index') }}"
     class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
    Voltar
  </a>
@endsection

@section('content')
<div
  class="bg-white shadow-sm rounded-lg p-6"
  x-data="purchaseForm({ products: {{ Js::from($products) }} })"
  x-cloak
>
  <form action="{{ route('purchases.store') }}" method="POST" @submit="prepareSubmit">
    @csrf

    {{-- Fornecedor --}}
    <div class="mb-6">
      <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-1">
        Fornecedor
      </label>
      <select
        id="supplier_id"
        name="supplier_id"
        class="w-full h-10 text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
      >
        @foreach($suppliers as $supplier)
          <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
        @endforeach
      </select>
    </div>

    {{-- Itens --}}
    <h3 class="text-sm font-semibold text-gray-800 mb-3">
      Itens da compra
    </h3>

    {{-- Sem produtos --}}
    <template x-if="products.length === 0">
      <div class="text-sm text-red-600 mb-4">
        Nenhum produto cadastrado. Cadastre um produto antes de criar uma compra.
      </div>
    </template>

    {{-- Lista de itens --}}
    <template x-for="(item, index) in items" :key="item.uid">
      <div class="flex items-center gap-3 mb-3 p-3 border border-gray-200 rounded-md bg-gray-50">

        {{-- Produto --}}
        <select
          :name="`items[${index}][product_id]`"
          x-model.number="item.product_id"
          @change="onProductChange(index)"
          class="flex-1 h-10 text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
          :disabled="products.length === 0"
        >
          <template x-for="p in products" :key="p.id">
            <option :value="p.id" x-text="p.name"></option>
          </template>
        </select>

        {{-- Quantidade --}}
        <input
          type="number"
          min="1"
          step="1"
          :name="`items[${index}][quantity]`"
          x-model.number="item.quantity"
          @input="recalculate(index)"
          placeholder="Qtd"
          class="w-20 h-10 text-sm text-center border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
          :disabled="products.length === 0"
        />

        {{-- Preço --}}
        <input
          type="text"
          :value="formatPrice(item.price)"
          class="w-28 h-10 text-sm border-gray-300 rounded-md bg-gray-100 text-gray-700 text-right"
          readonly
        />

        <input
          type="hidden"
          :name="`items[${index}][cost_price]`"
          x-model.number="item.price"
        />

        {{-- Subtotal --}}
        <div class="w-28 text-right">
          <div class="text-xs text-gray-500">Subtotal</div>
          <div class="text-sm font-medium text-gray-800" x-text="formatPrice(item.subtotal)"></div>
        </div>

        {{-- Remover --}}
        <button
          type="button"
          @click="removeItem(index)"
          class="h-10 px-3 text-sm bg-red-100 text-red-600 rounded-md hover:bg-red-200"
          title="Remover item"
        >
          ✕
        </button>
      </div>
    </template>

    {{-- Ações --}}
    <div class="mt-4">
      <button
        type="button"
        @click="addItem"
        class="h-10 px-4 text-sm bg-gray-100 rounded-md hover:bg-gray-200 disabled:opacity-50"
        :disabled="products.length === 0"
      >
        Adicionar Item
      </button>
    </div>

    {{-- Total --}}
    <div class="mt-6 flex items-center justify-between">
      <div class="text-sm text-gray-700">
        Total:
        <span class="text-lg font-semibold text-blue-600" x-text="formatPrice(total)"></span>
      </div>

      <button
        type="submit"
        class="h-10 px-6 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50"
        :disabled="products.length === 0"
      >
        Salvar
      </button>
    </div>
  </form>
</div>

<script>
function purchaseForm({ products }) {
  return {
    products,
    items: products.length ? [{
      uid: Date.now(),
      product_id: products[0].id,
      quantity: 1,
      price: Number(products[0].cost_price),
      subtotal: Number(products[0].cost_price),
    }] : [],

    get total() {
      return this.items.reduce((s, it) => s + Number(it.subtotal || 0), 0);
    },

    addItem() {
      if (!this.products.length) return;
      const p = this.products[0];
      this.items.push({
        uid: Date.now() + Math.random(),
        product_id: p.id,
        quantity: 1,
        price: Number(p.cost_price),
        subtotal: Number(p.cost_price),
      });
    },

    removeItem(index) {
      this.items.splice(index, 1);
    },

    onProductChange(index) {
      const pid = this.items[index].product_id;
      const prod = this.products.find(p => p.id == pid);
      this.items[index].price = prod ? Number(prod.cost_price) : 0;
      this.recalculate(index);
    },

    recalculate(index) {
      const it = this.items[index];
      it.quantity = Number(it.quantity) || 0;
      it.price = Number(it.price) || 0;
      it.subtotal = it.quantity * it.price;
    },

    formatPrice(value) {
      return Number(value || 0).toLocaleString('pt-BR', {
        minimumFractionDigits: 2
      });
    },

    prepareSubmit() {
      this.items.forEach((_, i) => this.recalculate(i));
    }
  }
}
</script>
@endsection
