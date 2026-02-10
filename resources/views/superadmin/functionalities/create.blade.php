@extends('superadmin.layout')

@section('title', 'Superadmin • Nova funcionalidade')
@section('page_title', 'Nova funcionalidade')
@section('page_subtitle', 'Crie uma funcionalidade e associe a um módulo.')

@section('content')
    <form method="POST" action="{{ route('superadmin.functionalities.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700">Módulo</label>
            <select name="module_id" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="" disabled {{ old('module_id') ? '' : 'selected' }}>Selecione</option>
                @foreach($modules as $m)
                    <option value="{{ $m->id }}" {{ (string) old('module_id') === (string) $m->id ? 'selected' : '' }}>
                        {{ $m->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Nome</label>
            <input name="name" value="{{ old('name') }}" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Route</label>
            <input name="route" value="{{ old('route') }}" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="ex: system/permissions ou permissions.index" />
            <p class="mt-1 text-xs text-gray-500">Usado pelo middleware para validar acesso. Pode ser path ou route name.
            </p>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Ordem</label>
            <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('superadmin.functionalities.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Salvar
            </button>
        </div>
    </form>
@endsection