@extends('system')

@section('title', 'Criar Usuário')
@section('page_title', 'Criar Usuário')

@section('top_actions')
  <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md shadow-sm hover:bg-gray-300">
    Voltar
  </a>
@endsection

@section('content')
  <div class="max-w-xl mx-auto">
    @if(session('success'))
      <div class="mb-6 rounded-md bg-green-50 p-4">
        <p class="text-sm text-green-700">{{ session('success') }}</p>
      </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-6 bg-white p-8 rounded-lg shadow-lg">
      @csrf

      <h2 class="text-lg font-semibold text-gray-900">Informações do usuário</h2>
      <p class="text-sm text-gray-500">Preencha os dados abaixo para criar um novo usuário.</p>

      <div>
        <label for="profile_id" class="block text-sm font-medium text-gray-700">Perfil</label>
        <div class="mt-1 relative">
          <select id="profile_id" name="profile_id" required
                  class="appearance-none w-full rounded-md border border-gray-300 bg-white py-3 px-4 pr-10 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Selecione um perfil</option>
            @foreach($profiles as $profile)
              <option value="{{ $profile->id }}" {{ old('profile_id') == $profile->id ? 'selected' : '' }}>
                {{ $profile->name ?? $profile->title ?? "Perfil #{$profile->id}" }}
              </option>
            @endforeach
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </div>
        </div>
        @error('profile_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="login" class="block text-sm font-medium text-gray-700">Login</label>
        <input id="login" name="login" type="text" value="{{ old('login') }}" required autofocus
               class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
        @error('login') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required
               class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
        @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
        <input id="password" name="password" type="password" required
               class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
        <p class="mt-2 text-xs text-gray-500">Mínimo 6 caracteres. Use uma senha forte.</p>
        @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required
               class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-3 px-4 text-sm shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
      </div>

      <div class="flex items-center justify-between pt-4 border-t border-gray-100">
        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
          Cancelar
        </a>

        <button type="submit" class="inline-flex items-center px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Criar Usuário
        </button>
      </div>
    </form>
  </div>
@endsection
