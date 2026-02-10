@extends('system')

@section('title', 'Perfis')
@section('page_title', 'Perfis')

@section('top_actions')
    <a href="{{ route('profiles.create') }}"
        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        Criar
    </a>
@endsection

@section('content')
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <form method="GET" action="{{ route('profiles.index') }}" class="flex items-center space-x-2">
                <label for="q" class="sr-only">Buscar</label>
                <input id="q" name="q" value="{{ request('q') }}" type="search" placeholder="Buscar por nome"
                    class="block w-64 rounded-md border border-gray-300 bg-white py-2 px-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                <button type="submit"
                    class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm">
                    Buscar
                </button>
                <button type="button" onclick="window.location='{{ route('profiles.index') }}'"
                    class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm">
                    Limpar
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            @if($profiles->count())
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuários
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criado em
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações
                            </th>
                        </tr>
                    </thead>

                    @php
                        $start = method_exists($profiles, 'firstItem') && $profiles->firstItem() ? $profiles->firstItem() : 1;
                      @endphp

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($profiles as $index => $profile)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $start + $index }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="font-semibold">{{ $profile->name }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <span
                                            class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-semibold text-indigo-700">
                                            {{ $profile->users_count ?? 0 }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ optional($profile->created_at)->format('d/m/Y H:i') ?? '—' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('profiles.edit', $profile->id) }}"
                                            class="text-blue-500 hover:text-blue-700">Editar</a>

                                        <form id="delete-profile-{{ $profile->id }}"
                                            action="{{ route('profiles.destroy', $profile->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <x-confirm-dialog form-id="delete-profile-{{ $profile->id }}" title="Excluir perfil"
                                            variant="danger" confirm-text="Sim, excluir" cancel-text="Cancelar" :message="implode(PHP_EOL, [
                                'Esse perfil tem ' . ($profile->users_count ?? 0) . ' usuários vinculados.',
                                'Ao excluir, os usuários serão apagados do sistema.',
                                'Deseja continuar?'
                            ])">
                                            <x-slot:trigger>
                                                <button type="button" class="text-red-600 hover:text-red-800">Excluir</button>
                                            </x-slot:trigger>
                                        </x-confirm-dialog>
                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-6 text-center text-gray-600">
                    Nenhum perfil encontrado.
                </div>
            @endif
        </div>

        @if(method_exists($profiles, 'links'))
            <div class="px-4 py-3 bg-white border-t border-gray-100 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Mostrando <span class="font-medium">{{ $profiles->firstItem() ?? 0 }}</span> até <span
                            class="font-medium">{{ $profiles->lastItem() ?? 0 }}</span> de <span
                            class="font-medium">{{ $profiles->total() ?? $profiles->count() }}</span>
                    </div>
                    <div>
                        {{ $profiles->appends(request()->only('q'))->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection