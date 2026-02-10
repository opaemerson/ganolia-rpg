@extends('superadmin.layout')

@section('title', 'Superadmin • Módulos')
@section('page_title', 'Módulos')
@section('page_subtitle', 'CRUD completo de módulos do sistema.')

@section('top_actions')
    <a href="{{ route('superadmin.modules.create') }}"
        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
        Novo módulo
    </a>
@endsection

@section('content')
    <div class="overflow-hidden rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nome</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Slug</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Ordem</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Ativo</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($modules as $module)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $module->id }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $module->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $module->slug }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $module->order }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($module->is_active)
                                <span
                                    class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-800">Sim</span>
                            @else
                                <span
                                    class="inline-flex rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-700">Não</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('superadmin.modules.edit', $module) }}"
                                    class="rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('superadmin.modules.destroy', $module) }}"
                                    onsubmit="return confirm('Remover este módulo?');">
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
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">Nenhum módulo cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $modules->links() }}
    </div>
@endsection