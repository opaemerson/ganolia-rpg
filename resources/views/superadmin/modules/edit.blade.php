@extends('superadmin.layout')

@section('title', 'Superadmin • Editar módulo')
@section('page_title', 'Editar módulo')
@section('page_subtitle', 'Atualize dados do módulo.')

@section('content')
  <form method="POST" action="{{ route('superadmin.modules.update', $module) }}" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm font-semibold text-gray-700">Nome</label>
      <input name="name" value="{{ old('name', $module->name) }}" required
             class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
    </div>

    <div>
      <label class="block text-sm font-semibold text-gray-700">Slug</label>
      <input name="slug" value="{{ old('slug', $module->slug) }}" required
             class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
      <div>
        <label class="block text-sm font-semibold text-gray-700">Ordem</label>
        <input type="number" name="order" value="{{ old('order', $module->order) }}" min="0"
               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
      </div>

      <div class="flex items-end">
        <label class="inline-flex items-center gap-2">
          <input type="checkbox" name="is_active" value="1" {{ old('is_active', $module->is_active) ? 'checked' : '' }}
                 class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
          <span class="text-sm font-semibold text-gray-700">Ativo</span>
        </label>
      </div>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('superadmin.modules.index') }}"
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
