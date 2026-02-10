@extends('superadmin.layout')

@section('title', 'Superadmin')
@section('page_title', 'Dashboard do Superadmin')
@section('page_subtitle', 'Gerencie módulos e funcionalidades do sistema sem usar o fluxo padrão.')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2">
        <a href="{{ route('superadmin.modules.index') }}"
            class="group rounded-2xl border border-gray-200 bg-gradient-to-br from-white to-gray-50 p-5 shadow-sm hover:shadow">
            <div class="text-sm font-semibold text-gray-900">CRUD de Módulos</div>
            <div class="mt-1 text-sm text-gray-600">Criar/editar/ativar módulos (sidebar e navegação).</div>
            <div class="mt-4 text-sm font-semibold text-indigo-700 group-hover:underline">Abrir →</div>
        </a>

        <a href="{{ route('superadmin.functionalities.index') }}"
            class="group rounded-2xl border border-gray-200 bg-gradient-to-br from-white to-gray-50 p-5 shadow-sm hover:shadow">
            <div class="text-sm font-semibold text-gray-900">CRUD de Funcionalidades</div>
            <div class="mt-1 text-sm text-gray-600">Gerenciar funcionalidades por módulo e rotas.</div>
            <div class="mt-4 text-sm font-semibold text-indigo-700 group-hover:underline">Abrir →</div>
        </a>
    </div>

    <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
        Esta área é exclusiva do perfil <strong>Superadmin</strong>.
    </div>
@endsection