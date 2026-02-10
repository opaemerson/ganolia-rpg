<!doctype html>
<html lang="pt-BR" x-data="{ sidebarOpen: false }" :class="{ 'overflow-hidden': sidebarOpen }">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'System')</title>
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @else
    <meta http-equiv="refresh" content="0; url=/" />
  @endif
  <style>
    [x-cloak] {
      display: none !important;
    }
  </style>
  @stack('styles')
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">
  @include('alerts')

  <div class="flex h-screen">
    <x-sidebar :modules="$modules" :active-module-slug="$activeModuleSlug" :user="$user" />
    <x-topbar />
    <x-sidebar-mobile :modules="$modules" :active-module-slug="$activeModuleSlug" :user="$user" />

    <main class="flex-1 overflow-auto pt-16 md:pt-0">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between mb-4">
          <h1 class="text-2xl font-semibold text-gray-900">@yield('page_title', 'Dashboard')</h1>
          <div>
            @yield('top_actions')
          </div>
        </div>

        <section class="bg-white rounded-lg shadow-sm p-6">
          @yield('content')
        </section>
      </div>
    </main>
  </div>

  @stack('scripts')
</body>

</html>