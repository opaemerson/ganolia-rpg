@props(['modules', 'activeModuleSlug' => null, 'user' => null])

@php
  $isSuperadmin = isset($user) && \App\Enum\ProfileEnum::SUPERADMIN->isUser($user);
  $isSuperadminActive = ($activeModuleSlug ?? request()->segment(1)) === 'superadmin';
@endphp

<aside x-show="sidebarOpen" x-transition:enter="transition transform duration-200"
  x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
  x-transition:leave="transition transform duration-150" x-transition:leave-start="translate-x-0"
  x-transition:leave-end="-translate-x-full"
  class="md:hidden fixed inset-y-0 left-0 z-30 w-64 bg-gray-800 text-gray-100 flex flex-col"
  @keydown.escape.window="sidebarOpen = false">
  <div class="px-4 py-5 border-b border-gray-700 flex items-center justify-between">
    <div class="text-lg font-semibold">System</div>
    <button @click="sidebarOpen = false" class="p-1 rounded text-gray-200 hover:bg-gray-700/40">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <nav class="px-2 py-4 overflow-y-auto">
    <ul class="space-y-1">
      @if($isSuperadmin)
        <li>
          <a href="{{ route('superadmin.dashboard') }}" @click="sidebarOpen = false"
            class="block px-3 py-2 rounded-md text-sm font-medium truncate
                          {{ $isSuperadminActive ? 'bg-gradient-to-r from-fuchsia-600 to-indigo-600 text-white' : 'hover:bg-gray-700/50' }}">
            Superadmin
          </a>
        </li>
        <li class="border-t border-gray-700 my-2"></li>
      @endif
      @foreach($modules as $module)
        @php
          $isActive = isset($activeModuleSlug)
            ? ($activeModuleSlug === $module->slug)
            : (request()->segment(1) === $module->slug);
        @endphp
        <li>
          <a href="{{ url($module->slug) }}" @click="sidebarOpen = false"
            class="block px-3 py-2 rounded-md text-sm font-medium truncate
                          {{ $isActive ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white' : 'hover:bg-gray-700/50' }}">
            {{ $module->name }}
          </a>
        </li>
      @endforeach
    </ul>
  </nav>

  <div class="mt-auto px-4 py-4 border-t border-gray-700 text-sm">
    @if(isset($user))
      <div class="font-medium">{{ $user->name ?? $user->login ?? 'User' }}</div>
      <div class="text-gray-400 text-xs truncate">{{ $user->email ?? '' }}</div>
    @endif
  </div>
</aside>