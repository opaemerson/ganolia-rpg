<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} • UI Test</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <meta http-equiv="refresh" content="0; url=/" />
    @endif
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-3xl px-6 py-10" x-data="{ open: false, count: 0, name: '' }">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-semibold tracking-tight">Tailwind + Alpine.js</h1>
            <a href="/" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">Voltar</a>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-600">
                Se você está vendo estilos (cores, spacing, sombras) e as interações abaixo funcionam, então Tailwind e
                Alpine estão ok.
            </p>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-lg bg-slate-50 p-4">
                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Alpine toggle</div>

                    <button type="button"
                        class="mt-3 inline-flex items-center rounded-lg bg-indigo-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        @click="open = !open">
                        <span x-text="open ? 'Fechar' : 'Abrir'"></span>
                    </button>

                    <div class="mt-3 rounded-lg border border-indigo-200 bg-indigo-50 p-3 text-sm text-indigo-900"
                        x-show="open" x-transition x-cloak>
                        Conteúdo controlado por Alpine (x-show + transition).
                    </div>
                </div>

                <div class="rounded-lg bg-slate-50 p-4">
                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Counter</div>

                    <div class="mt-3 flex items-center gap-3">
                        <button type="button"
                            class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium hover:bg-slate-100"
                            @click="count--">-
                        </button>

                        <div class="min-w-16 rounded-lg bg-white px-3 py-2 text-center text-sm font-semibold tabular-nums border border-slate-200"
                            x-text="count"></div>

                        <button type="button"
                            class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium hover:bg-slate-100"
                            @click="count++">+
                        </button>
                    </div>
                </div>

                <div class="rounded-lg bg-slate-50 p-4 sm:col-span-2">
                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">x-model</div>

                    <label class="mt-3 block text-sm font-medium text-slate-700">Seu nome</label>
                    <input type="text"
                        class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                        placeholder="Digite algo..." x-model="name" />

                    <p class="mt-3 text-sm text-slate-700">
                        Olá, <span class="font-semibold" x-text="name || 'mundo'"></span>.
                    </p>
                </div>
            </div>

            <div class="mt-6 text-xs text-slate-500">
                Dica: rode <span class="font-mono">./vendor/bin/sail npm run dev</span> para HMR.
            </div>
        </div>
    </div>
</body>

</html>