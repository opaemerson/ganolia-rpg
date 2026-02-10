@props([
    'formId',
    'title' => 'Confirmar ação',
    'message' => '',
    'confirmText' => 'Confirmar',
    'cancelText' => 'Cancelar',
    'variant' => 'danger',
])

@php
    $confirmClasses = match ($variant) {
        'danger' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
        'warning' => 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500',
        default => 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500',
    };

    $iconBg = match ($variant) {
        'danger' => 'bg-red-100',
        'warning' => 'bg-amber-100',
        default => 'bg-indigo-100',
    };

    $iconColor = match ($variant) {
        'danger' => 'text-red-600',
        'warning' => 'text-amber-600',
        default => 'text-indigo-600',
    };
@endphp

<div x-data="{ open: false }" class="inline-block">
  <span @click="open = true">
    {{ $trigger ?? $slot }}
  </span>

  <div
    x-cloak
    x-show="open"
    x-transition.opacity
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
  >
    <div class="absolute inset-0 bg-black/30 backdrop-blur-[2px]" @click="open = false"></div>

    <div
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0 scale-95"
      @click.away="open = false"
      class="relative w-full max-w-sm rounded-xl bg-white shadow-xl"
      role="dialog"
      aria-modal="true"
    >
      <!-- Header -->
      <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
        <h3 class="text-base font-semibold text-gray-900">{{ $title }}</h3>
        <button type="button"
          class="rounded-lg p-1 text-gray-400 transition-all hover:bg-gray-100 hover:text-gray-600"
          @click="open = false" aria-label="Fechar">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>

      <!-- Content -->
      <div class="px-5 py-6">
        <div class="flex flex-col items-center text-center">
          <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full {{ $iconBg }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>

          @if($message)
            <div class="text-sm leading-6 text-gray-700">
              {!! nl2br(e($message)) !!}
            </div>
          @endif
        </div>
      </div>

      <!-- Footer -->
      <div class="flex gap-2 border-t border-gray-100 bg-gray-50 px-5 py-4">
        <button type="button"
          class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-all hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
          @click="open = false">
          {{ $cancelText }}
        </button>

        <button type="button"
          class="flex-1 rounded-lg px-4 py-2 text-sm font-medium text-white transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $confirmClasses }}"
          @click="document.getElementById(@js($formId))?.submit(); open = false">
          {{ $confirmText }}
        </button>
      </div>
    </div>
  </div>
</div>
