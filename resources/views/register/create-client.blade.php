@extends('system')

@section('title', 'Criar Cliente')
@section('page_title', 'Criar Cliente')

@section('top_actions')
  <a href="{{ route('clients.index') }}"
     class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md shadow-sm hover:bg-gray-300">
    Voltar
  </a>
@endsection

@section('content')
  <div class="max-w-2xl mx-auto">
    @if(session('success'))
      <div class="mb-6 rounded-md bg-green-50 p-4">
        <p class="text-sm text-green-700">{{ session('success') }}</p>
      </div>
    @endif

    @if($errors->any())
      <div class="mb-4 rounded-md bg-red-50 p-4">
        <p class="text-sm font-medium text-red-800">Por favor corrija os erros abaixo.</p>
      </div>
    @endif

    <form action="{{ route('clients.store') }}" method="POST" class="space-y-6 bg-white p-8 rounded-lg shadow-lg">
      @csrf

      <h2 class="text-lg font-semibold text-gray-900">Informações do cliente</h2>
      <p class="text-sm text-gray-500">Preencha os dados abaixo.</p>

      {{-- Nome --}}
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
        <input id="name" name="name" value="{{ old('name') }}" required
               class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
        @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Tipo e Documento --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
          <select id="type" name="type" required
                  class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="fisica" {{ old('type') == 'fisica' ? 'selected' : '' }}>Pessoa Física</option>
            <option value="juridica" {{ old('type') == 'juridica' ? 'selected' : '' }}>Pessoa Jurídica</option>
          </select>
          @error('type') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="document" class="block text-sm font-medium text-gray-700">Documento</label>
          <input id="document" name="document" value="{{ old('document') }}"
                 class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
          @error('document') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- Telefone e E-mail --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
          <input id="phone" name="phone" value="{{ old('phone') }}"
                 class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
          @error('phone') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}"
                 class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
          @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
      </div>

      <hr class="border-t border-gray-100" />

      <h3 class="text-md font-semibold text-gray-800">Endereço</h3>


      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="sm:col-span-2">
          <label for="street" class="block text-sm font-medium text-gray-700">Rua</label>
          <input id="street" name="street" value="{{ old('street') }}" placeholder="Rua"
                class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400
                focus:border-indigo-500 focus:ring-indigo-500" />
          @error('street')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="cep" class="block text-sm font-medium text-gray-500">CEP</label>
          <input id="cep" name="cep" value="{{ old('cep') }}" placeholder="CEP"
                class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400
                focus:border-indigo-500 focus:ring-indigo-500" />
          @error('cep')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
          <label for="number" class="block text-sm font-medium text-gray-700">Número</label>
          <input id="number" name="number" value="{{ old('number') }}" placeholder="Número"
                 class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
          @error('number') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="city" class="block text-sm font-medium text-gray-700">Cidade</label>
          <input id="city" name="city" value="{{ old('city') }}" placeholder="Cidade"
                 class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
          @error('city') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="state" class="block text-sm font-medium text-gray-700">UF</label>
          <input id="state" name="state" value="{{ old('state') }}" placeholder="UF"
                 class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
          @error('state') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
      </div>

      <div>
        <label for="notes" class="block text-sm font-medium text-gray-700">Observações</label>
        <textarea id="notes" name="notes" rows="4"
                  class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
        @error('notes') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div class="flex items-center justify-between pt-4 border-t border-gray-100">
        <a href="{{ route('clients.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
          Cancelar
        </a>

        <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Criar Cliente
        </button>
    </div>
    </form>
  </div>
@endsection
