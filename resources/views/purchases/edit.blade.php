@extends('system')

@section('title', 'Editar Compra')
@section('page_title', 'Editar Compra')

@section('top_actions')
  <a href="{{ route('purchases.index') }}"
     class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
    Voltar
  </a>
@endsection

@section('content')
  <div
    class="bg-white shadow-sm rounded-lg p-6"
    x-data="purchaseForm({
      products: {{ Js::from($products) }},
      items: {{ Js::from(
        $purchase->items->map(fn ($item) => [
          'uid'        => $item->id,
          'product_id' => $item->product_id,
          'quantity'   => $item->quantity,
          'price'      => $item->cost_price ?? $item->product->cost_price,
          'subtotal'   => $item->quantity * ($item->cost_price ?? $item->product->cost_price),
        ])
      ) }}
    })"
    x-cloak
  >
    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST" @submit="prepareSubmit">
      @csrf
      @method('PUT')

      {{-- Fornecedor --}}
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Fornecedor</label>
        <select name="supplier_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
          @foreach($suppliers as $supplier)
            <option value="{{ $supplier->id }}"
              @selected($purchase->supplier_id == $supplier->id)>
              {{ $supplier->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Itens --}}
      <h3 class="text-md font-medium text-gray-800 mb-2">Itens</h3>

      <template x-for="(item, index) in items" :key="item.uid">
        <div class="flex items-center space-x-2 mb-2">

          {{-- Produto --}}
          <select
            :name="`items[${index}][product_id]`"
            x-model.number="item.product_id"
            @change="onProductChange(index)"
            class="border-gray-300 rounded-md"
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
            class="w-20 border-gray-300 rounded-md"
          />

          {{-- Preço --}}
          <input
            type="text"
            :value="formatPrice(item.price)"
            class="w-32 border-gray-300 rounded-md bg-gray-100 text-gray-700"
            readonly
          />

          <input
            type="hidden"
            :name="`items[${index}][cost_price]`"
            x-model.number="item.price"
          />

          {{-- Subtotal --}}
          <div class="w-36 text-sm text-gray-700">
            <div>Subtotal:</div>
            <div class="font-medium" x-text="formatPrice(item.subtotal)"></div>
          </div>

          {{-- Remover --}}
          <button
            type="button"
            @click="removeItem(index)"
            class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-700"
          >
            Remover
          </button>
        </div>
      </template>

      {{-- Ações --}}
      <div class="mt-2">
        <button
          type="button"
          @click="addItem"
          class="px-3 py-2 bg-gray-100 rounded-md hover:bg-gray-200"
        >
          Adicionar Item
        </button>
      </div>

      {{-- Total --}}
      <div class="mt-6 text-right">
        <div class="text-sm text-gray-700">
          Total:
          <span class="font-medium" x-text="formatPrice(total)"></span>
        </div>

        <button
          type="submit"
          class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
        >
          Atualizar
        </button>
      </div>
    </form>
  </div>

  <script>
    function purchaseForm({ products, items }) {
      return {
        products,
        items,

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
          return Number(value || 0)
            .toLocaleString('pt-BR', { minimumFractionDigits: 2 });
        },

        prepareSubmit() {
          this.items.forEach((_, i) => this.recalculate(i));
        }
      }
    }
  </script>
@endsection
