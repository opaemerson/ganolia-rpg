@extends('system')

@section('title', 'Fornecedores')
@section('page_title', 'Fornecedores')

@section('top_actions')
  <a href="{{ route('suppliers.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700">
    Criar Fornecedor
  </a>
@endsection

@section('content')
  <div class="max-w-4xl mx-auto">
    @if(session('success'))
      <div class="mb-6 rounded-md bg-green-50 p-4">
        <p class="text-sm text-green-700">{{ session('success') }}</p>
      </div>
    @endif

    <div class="mb-4 flex items-center justify-between">
      <form method="GET" action="{{ route('suppliers.index') }}" class="flex items-center space-x-2">
        <input name="q" value="{{ request('q') }}" placeholder="Buscar por nome" class="rounded-md border border-gray-300 py-2 px-3 text-sm shadow-sm" />
        <button type="submit" class="inline-flex items-center px-3 py-2 bg-gray-200 text-sm rounded-md hover:bg-gray-300">Buscar</button>
      </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
      @if($suppliers->count())
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">#</th>
              <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Nome</th>
              <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Documento</th>
              <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Telefone</th>
              <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Email</th>
              <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Ações</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-100">
            @foreach($suppliers as $i => $supplier)
              <tr>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $suppliers->firstItem() + $i }}</td>
                <td class="px-4 py-3 text-sm text-gray-900">{{ $supplier->name }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $supplier->document ?? '—' }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $supplier->phone ?? '—' }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $supplier->email ?? '—' }}</td>
                <td class="px-4 py-3 text-right text-sm">
                  <div class="inline-flex items-center space-x-2">
                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-blue-400 hover:text-blue-200">
                      Editar
                    </a>

                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="text-red-600 hover:text-red-900"
                              onclick="return confirm('Excluir fornecedor?');">
                        Excluir
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="p-4">
          {{ $suppliers->appends(request()->only('q'))->links() }}
        </div>
      @else
        <div class="p-6 text-center text-gray-600">Nenhum fornecedor encontrado.</div>
      @endif
    </div>
  </div>
@endsection
