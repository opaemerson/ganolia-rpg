<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Superadmin')</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <meta http-equiv="refresh" content="0; url=/" />
    @endif

    @stack('styles')
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">
    @include('alerts')

    <header class="sticky top-0 z-40 border-b border-gray-200 bg-white/80 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-fuchsia-600 to-indigo-700"></div>
                    <div class="leading-tight">
                        <div class="text-sm font-semibold text-gray-900">Superadmin</div>
                        <div class="text-xs text-gray-500">Área de configuração do sistema</div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('system.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Voltar ao sistema
                    </a>
                    <a href="{{ url('/logout') }}"
                        class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">
                        Sair
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <aside class="lg:col-span-3">
                <nav class="space-y-2 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <a href="{{ route('superadmin.dashboard') }}"
                        class="block rounded-xl px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                        Dashboard
                    </a>
                    <a href="{{ route('superadmin.modules.index') }}"
                        class="block rounded-xl px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                        CRUD de Módulos
                    </a>
                    <a href="{{ route('superadmin.functionalities.index') }}"
                        class="block rounded-xl px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                        CRUD de Funcionalidades
                    </a>
                </nav>
            </aside>

            <main class="lg:col-span-9">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">@yield('page_title', 'Superadmin')</h1>
                            @hasSection('page_subtitle')
                                <p class="mt-1 text-sm text-gray-600">@yield('page_subtitle')</p>
                            @endif
                        </div>
                        <div class="shrink-0">@yield('top_actions')</div>
                    </div>

                    <div class="mt-6">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>