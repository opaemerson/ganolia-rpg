@props(['modules', 'activeModuleSlug' => null, 'user' => null])

@php
  $isSuperadmin = isset($user) && \App\Enum\ProfileEnum::SUPERADMIN->isUser($user);
  $isSuperadminActive = ($activeModuleSlug ?? request()->segment(1)) === 'superadmin';
@endphp

<div x-data="sidebar()" x-init="init()" :class="collapsed ? 'w-16' : 'w-64'"
  class="bg-gradient-to-b from-gray-900 to-gray-800 text-gray-100 shrink-0 hidden md:flex flex-col transition-all duration-300 ease-in-out shadow-2xl">
  <div class="px-4 py-5 border-b border-gray-700/50 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="flex items-center gap-2" x-show="!collapsed" x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-x-4"
        x-transition:enter-end="opacity-100 transform translate-x-0">
        <div
          class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-lg">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
          </svg>
        </div>
        <span class="text-lg font-bold tracking-tight">Sistema</span>
      </div>
    </div>

    <button @click="toggle()"
      class="p-2 rounded-lg text-gray-300 hover:text-white hover:bg-gray-700/50 transition-all duration-200">
      <svg x-show="!collapsed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
      </svg>

      <svg x-show="collapsed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
      </svg>
    </button>
  </div>

  <nav class="px-3 py-4 flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-transparent">
    <ul class="space-y-2">
      @if($isSuperadmin)
        <li>
          <a href="{{ route('superadmin.dashboard') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-left transition-all duration-200
                            {{ $isSuperadminActive ? 'bg-gradient-to-r from-fuchsia-600 to-indigo-600 shadow-lg shadow-indigo-500/30 text-white' : 'hover:bg-gray-700/40 text-gray-300 hover:text-white' }}">
            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-semibold transition-all duration-200
                            {{ $isSuperadminActive ? 'bg-white/20' : 'bg-gray-700 group-hover:bg-gray-600' }}">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 2l9 4.5v6c0 5-3.6 9.4-9 10-5.4-.6-9-5-9-10v-6L12 2z" />
              </svg>
            </span>
            <span x-show="!collapsed" x-cloak class="truncate">Superadmin</span>
          </a>
        </li>
        <li class="border-t border-gray-700/50 my-2"></li>
      @endif
      @foreach($modules as $module)
        @php
          $isActive = isset($activeModuleSlug)
            ? ($activeModuleSlug === $module->slug)
            : (request()->segment(1) === $module->slug);
        @endphp

        <li
          x-data="moduleItem({{ $module->id }}, @js($module->slug), @js($module->functionalities->map->only(['id', 'name', 'route'])->values()))"
          class="relative">
          <div class="flex items-center gap-1">
            <button @click="toggle()" type="button"
              class="group flex-1 flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-left transition-all duration-200
                                {{ $isActive ? 'bg-gradient-to-r from-blue-600 to-blue-500 shadow-lg shadow-blue-500/30 text-white' : 'hover:bg-gray-700/40 text-gray-300 hover:text-white' }}">
              <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-semibold transition-all duration-200
                                {{ $isActive ? 'bg-white/20' : 'bg-gray-700 group-hover:bg-gray-600' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                </svg>
              </span>
              <span x-show="!collapsed" x-cloak class="truncate">{{ $module->name }}</span>
            </button>

            <button @click="toggle()"
              class="p-2 text-gray-400 hover:text-white hover:bg-gray-700/40 rounded-lg transition-all duration-200"
              x-show="!collapsed" x-cloak>
              <svg :class="open ? 'rotate-90' : ''" class="h-4 w-4 transition-transform duration-300"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>

          <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="mt-2 ml-11 space-y-1">
            <div x-show="loading" class="flex items-center gap-2 text-xs text-gray-400 py-2 px-3">
              <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
              </svg>
              Carregando...
            </div>

            <template x-if="!loading && funcs.length === 0">
              <div class="text-xs text-gray-500 py-2 px-3">Nenhuma funcionalidade disponível</div>
            </template>

            <ul class="space-y-1">
              <template x-for="f in funcs" :key="f.id">
                <li>
                  <a :href="`/${f.route}`"
                    class="group flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-white hover:bg-gray-700/40 transition-all duration-200">
                    <span
                      class="w-1.5 h-1.5 rounded-full bg-gray-600 group-hover:bg-blue-500 transition-colors duration-200"></span>
                    <span x-text="f.name"></span>
                  </a>
                </li>
              </template>
            </ul>
          </div>
        </li>
      @endforeach
    </ul>
  </nav>

  <div class="px-4 py-4 border-t border-gray-700/50 bg-gray-900/50">
    @if(isset($user))
      <div class="flex items-center gap-3">
        <div class="flex-shrink-0">
          <div
            class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold shadow-lg"
            title="{{ $user->name ?? $user->email ?? 'User' }}">
            {{ Str::limit($user->name ?? $user->login ?? 'U', 1, '') }}
          </div>
        </div>

        <div class="flex-1 min-w-0" x-show="!collapsed" x-cloak x-transition:enter="transition ease-out duration-200"
          x-transition:enter-start="opacity-0 transform -translate-x-4"
          x-transition:enter-end="opacity-100 transform translate-x-0">
          <div class="font-medium text-white truncate">{{ $user->name ?? $user->login ?? 'User' }}</div>
          <div class="text-gray-400 text-xs truncate">{{ $user->email ?? '' }}</div>
        </div>

        <a href="{{ url('/logout') }}" x-show="!collapsed" x-cloak
          x-transition:enter="transition ease-out duration-200 delay-75"
          x-transition:enter-start="opacity-0 transform translate-x-4"
          x-transition:enter-end="opacity-100 transform translate-x-0"
          class="group flex-shrink-0 p-2 rounded-lg bg-red-600/10 hover:bg-red-600 text-red-400 hover:text-white transition-all duration-200"
          title="Sair">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
          </svg>
        </a>
      </div>
    @endif
  </div>
</div>

<script>
  function moduleItem(moduleId, moduleSlug, initialFuncs = []) {
    return {
      open: false,
      loading: false,
      funcs: Array.isArray(initialFuncs) ? initialFuncs : [],
      async toggle() {
        if (this.open) { this.open = false; return; }

        if (this.funcs.length) { this.open = true; return; }

        this.loading = true;
        try {
          const res = await fetch(`/modules/${moduleId}/functionalities`, {
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json' }
          });
          if (!res.ok) throw new Error('Erro ao carregar');
          this.funcs = await res.json();
          this.open = true;
        } catch (e) {
          this.funcs = [];
          this.open = true;
        } finally {
          this.loading = false;
        }
      }
    }
  }

  function sidebar() {
    return {
      collapsed: false,
      init() {
        try {
          const saved = localStorage.getItem('sidebar-collapsed');
          this.collapsed = saved === '1';
        } catch (e) { }
      },
      toggle() {
        this.collapsed = !this.collapsed;
        try {
          localStorage.setItem('sidebar-collapsed', this.collapsed ? '1' : '0');
        } catch (e) { }
      }
    }
  }
</script>