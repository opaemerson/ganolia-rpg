@extends('system')

@section('title', 'Editar Venda')
@section('page_title', 'Editar Venda')

@section('top_actions')
  <a href="{{ route('sales.index') }}"
     class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
    Voltar
  </a>
@endsection

@section('content')
<div
  class="bg-white shadow-sm rounded-lg p-6"
  x-data="saleEditForm({ products: {{ Js::from($products) }}, sale: {{ Js::from($sale->load('items.product')) }} })"
  x-cloak
>
  <form :action="`{{ url('sales') }}/${sale.id}`" method="POST" @submit="prepareSubmit">
    @csrf
    @method('PUT')

    {{-- Cliente --}}
    <div class="mb-6">
      <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">
        Cliente
      </label>
      <select
        id="client_id"
        name="client_id"
        x-model="sale.client_id"
        class="w-full h-10 text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
      >
        @foreach($clients as $client)
          <option value="{{ $client->id }}">{{ $client->name }}</option>
        @endforeach
      </select>
    </div>

    {{-- Itens --}}
    <h3 class="text-sm font-semibold text-gray-800 mb-3">
      Itens da venda
    </h3>

    {{-- Sem produtos --}}
    <template x-if="products.length === 0">
      <div class="text-sm text-red-600 mb-4">
        Nenhum produto cadastrado. Cadastre um produto antes de editar a venda.
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
          @foreach($products as $p)
            <option value="{{ $p->id }}" data-price="{{ $p->sale_price }}">{{ $p->name }}</option>
          @endforeach
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

        {{-- Preço unitário (somente leitura) --}}
        <input
          type="text"
          :value="formatPrice(item.price)"
          class="w-28 h-10 text-sm border-gray-300 rounded-md bg-gray-100 text-gray-700 text-right"
          readonly
        />

        <input
          type="hidden"
          :name="`items[${index}][sale_price]`"
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
        Atualizar
      </button>
    </div>
  </form>
</div>

<script>
function saleEditForm({ products = [], sale = null }) {
  const initialItems = (sale && sale.items ? sale.items.map(it => ({
    uid: Date.now() + Math.random(),
    product_id: it.product_id,
    quantity: Number(it.quantity),
    price: Number(it.product?.sale_price ?? it.sale_price ?? 0),
    subtotal: Number(it.quantity) * Number(it.product?.sale_price ?? it.sale_price ?? 0),
  })) : []);

  return {
    products,
    sale: sale || { id: null, client_id: null },
    items: initialItems.length ? initialItems : (products.length ? [{
      uid: Date.now(),
      product_id: products[0].id,
      quantity: 1,
      price: Number(products[0].sale_price),
      subtotal: Number(products[0].sale_price),
    }] : []),

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
        price: Number(p.sale_price),
        subtotal: Number(p.sale_price),
      });
    },

    removeItem(index) {
      this.items.splice(index, 1);
    },

    onProductChange(index) {
      const pid = this.items[index].product_id;
      const prod = this.products.find(p => String(p.id) === String(pid));
      if (prod) {
        this.items[index].price = Number(prod.sale_price);
      } else {
        const selects = document.querySelectorAll('select[name^="items"]');
        const sel = selects[index];
        const opt = sel && sel.options[sel.selectedIndex];
        const priceAttr = opt ? opt.getAttribute('data-price') : null;
        this.items[index].price = priceAttr ? Number(priceAttr) : 0;
      }
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

    prepareSubmit(event) {
      this.items.forEach((_, i) => this.recalculate(i));
      if (!this.items.length || this.items.some(it => !it.product_id || it.quantity <= 0)) {
        event.preventDefault();
        alert('Verifique os itens: produto e quantidade são obrigatórios.');
      }
    }
  }
}
</script>
@endsection
