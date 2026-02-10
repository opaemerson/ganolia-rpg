{{-- resources/views/components/topbar.blade.php --}}
<div class="md:hidden fixed top-0 left-0 right-0 z-30 bg-white shadow">
  <div class="flex items-center justify-between px-4 py-2">
    <div class="text-lg font-semibold">System</div>
    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-md text-gray-700 hover:bg-gray-100">
      <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
      <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
  </div>
</div>

<div x-show="sidebarOpen" x-transition.opacity class="md:hidden fixed inset-0 z-20 bg-black/40" @click="sidebarOpen = false" aria-hidden="true"></div>
