@extends('superadmin.layout')

@section('title', 'Superadmin • Funcionalidades')
@section('page_title', 'Funcionalidades')
@section('page_subtitle', 'CRUD completo de funcionalidades, associadas a módulos.')

@section('top_actions')
    <a href="{{ route('superadmin.functionalities.create') }}"
        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
        Nova funcionalidade
    </a>
@endsection

@section('content')
    <form method="GET" class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end">
        <div>
            <label class="block text-sm font-semibold text-gray-700">Filtrar por módulo</label>
            <select name="module_id"
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Todos</option>
                @foreach($modules as $m)
                    <option value="{{ $m->id }}" {{ (string) request('module_id') === (string) $m->id ? 'selected' : '' }}>
                        {{ $m->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Aplicar
            </button>
        </div>
    </form>

    <div class="overflow-hidden rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Módulo</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nome</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Route</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Ordem</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($functionalities as $f)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $f->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $f->module?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $f->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $f->route }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $f->order }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('superadmin.functionalities.edit', $f) }}"
                                    class="rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('superadmin.functionalities.destroy', $f) }}"
                                    onsubmit="return confirm('Remover esta funcionalidade?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-lg bg-red-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-red-700">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">Nenhuma funcionalidade cadastrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $functionalities->links() }}
    </div>
@endsection