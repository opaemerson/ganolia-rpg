<div class="fixed top-4 right-4 z-50 w-full max-w-sm space-y-3">
    @php
        $toastDurationMs = 5000;
    @endphp

    @if ($errors->any())
        <div x-data="{ show: true, progress: 100, duration: {{ $toastDurationMs }}, _interval: null, _start: null }"
            x-init="_start = Date.now(); _interval = setInterval(() => { const elapsed = Date.now() - _start; progress = Math.max(0, 100 - (elapsed / duration) * 100); if (progress <= 0) { show = false; clearInterval(_interval); } }, 50); setTimeout(() => { show = false; clearInterval(_interval); }, duration);"
            x-show="show" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" role="alert"
            class="overflow-hidden rounded-2xl border border-red-200 bg-white shadow-lg">
            <div class="flex items-start gap-3 p-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-600 text-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v4m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                    </svg>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Erros encontrados</p>
                            <p class="text-xs text-gray-500">Corrija e tente novamente</p>
                        </div>
                        <button type="button"
                            class="inline-flex rounded-lg p-1 text-gray-400 hover:bg-gray-50 hover:text-gray-700"
                            @click="show = false; clearInterval(_interval);" aria-label="Fechar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <ul class="mt-2 max-h-32 list-disc space-y-1 overflow-auto pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="h-1 w-full bg-red-100">
                <div class="h-1 bg-red-600 transition-[width] duration-100" :style="`width: ${progress}%`"></div>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div x-data="{ show: true, progress: 100, duration: {{ $toastDurationMs }}, _interval: null, _start: null }"
            x-init="_start = Date.now(); _interval = setInterval(() => { const elapsed = Date.now() - _start; progress = Math.max(0, 100 - (elapsed / duration) * 100); if (progress <= 0) { show = false; clearInterval(_interval); } }, 50); setTimeout(() => { show = false; clearInterval(_interval); }, duration);"
            x-show="show" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" role="alert"
            class="overflow-hidden rounded-2xl border border-emerald-200 bg-white shadow-lg">
            <div class="flex items-start gap-3 p-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Sucesso</p>
                            <p class="mt-0.5 text-sm text-gray-700">{{ session('success') }}</p>
                        </div>
                        <button type="button"
                            class="inline-flex rounded-lg p-1 text-gray-400 hover:bg-gray-50 hover:text-gray-700"
                            @click="show = false; clearInterval(_interval);" aria-label="Fechar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="h-1 w-full bg-emerald-100">
                <div class="h-1 bg-emerald-600 transition-[width] duration-100" :style="`width: ${progress}%`"></div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true, progress: 100, duration: {{ $toastDurationMs }}, _interval: null, _start: null }"
            x-init="_start = Date.now(); _interval = setInterval(() => { const elapsed = Date.now() - _start; progress = Math.max(0, 100 - (elapsed / duration) * 100); if (progress <= 0) { show = false; clearInterval(_interval); } }, 50); setTimeout(() => { show = false; clearInterval(_interval); }, duration);"
            x-show="show" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" role="alert"
            class="overflow-hidden rounded-2xl border border-red-200 bg-white shadow-lg">
            <div class="flex items-start gap-3 p-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-600 text-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v4m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                    </svg>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Erro</p>
                            <p class="mt-0.5 text-sm text-gray-700">{{ session('error') }}</p>
                        </div>
                        <button type="button"
                            class="inline-flex rounded-lg p-1 text-gray-400 hover:bg-gray-50 hover:text-gray-700"
                            @click="show = false; clearInterval(_interval);" aria-label="Fechar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="h-1 w-full bg-red-100">
                <div class="h-1 bg-red-600 transition-[width] duration-100" :style="`width: ${progress}%`"></div>
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div x-data="{ show: true, progress: 100, duration: {{ $toastDurationMs }}, _interval: null, _start: null }"
            x-init="_start = Date.now(); _interval = setInterval(() => { const elapsed = Date.now() - _start; progress = Math.max(0, 100 - (elapsed / duration) * 100); if (progress <= 0) { show = false; clearInterval(_interval); } }, 50); setTimeout(() => { show = false; clearInterval(_interval); }, duration);"
            x-show="show" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" role="alert"
            class="overflow-hidden rounded-2xl border border-amber-200 bg-white shadow-lg">
            <div class="flex items-start gap-3 p-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-600 text-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.5 20h15a2 2 0 001.71-3.14l-7.5-13a2 2 0 00-3.42 0z" />
                    </svg>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Atenção</p>
                            <p class="mt-0.5 text-sm text-gray-700">{{ session('warning') }}</p>
                        </div>
                        <button type="button"
                            class="inline-flex rounded-lg p-1 text-gray-400 hover:bg-gray-50 hover:text-gray-700"
                            @click="show = false; clearInterval(_interval);" aria-label="Fechar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="h-1 w-full bg-amber-100">
                <div class="h-1 bg-amber-600 transition-[width] duration-100" :style="`width: ${progress}%`"></div>
            </div>
        </div>
    @endif

    @if (session('info'))
        <div x-data="{ show: true, progress: 100, duration: {{ $toastDurationMs }}, _interval: null, _start: null }"
            x-init="_start = Date.now(); _interval = setInterval(() => { const elapsed = Date.now() - _start; progress = Math.max(0, 100 - (elapsed / duration) * 100); if (progress <= 0) { show = false; clearInterval(_interval); } }, 50); setTimeout(() => { show = false; clearInterval(_interval); }, duration);"
            x-show="show" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" role="alert"
            class="overflow-hidden rounded-2xl border border-sky-200 bg-white shadow-lg">
            <div class="flex items-start gap-3 p-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-600 text-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                    </svg>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Info</p>
                            <p class="mt-0.5 text-sm text-gray-700">{{ session('info') }}</p>
                        </div>
                        <button type="button"
                            class="inline-flex rounded-lg p-1 text-gray-400 hover:bg-gray-50 hover:text-gray-700"
                            @click="show = false; clearInterval(_interval);" aria-label="Fechar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="h-1 w-full bg-sky-100">
                <div class="h-1 bg-sky-600 transition-[width] duration-100" :style="`width: ${progress}%`"></div>
            </div>
        </div>
    @endif
</div>