@extends('superadmin.layout')

@section('title', 'Superadmin • Editar funcionalidade')
@section('page_title', 'Editar funcionalidade')
@section('page_subtitle', 'Atualize dados e associação com módulo.')

@section('content')
    <form method="POST" action="{{ route('superadmin.functionalities.update', $functionality) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700">Módulo</label>
            <select name="module_id" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                @foreach($modules as $m)
                    <option value="{{ $m->id }}" {{ (string) old('module_id', $functionality->module_id) === (string) $m->id ? 'selected' : '' }}>
                        {{ $m->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Nome</label>
            <input name="name" value="{{ old('name', $functionality->name) }}" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Route</label>
            <input name="route" value="{{ old('route', $functionality->route) }}" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Ordem</label>
            <input type="number" name="order" value="{{ old('order', $functionality->order) }}" min="0"
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('superadmin.functionalities.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Voltar
            </a>
            <button type="submit"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Salvar
            </button>
        </div>
    </form>
@endsection