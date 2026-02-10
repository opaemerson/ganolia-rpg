@extends('system')

@section('title', 'Permissões')
@section('page_title', 'Permissões')

@section('content')
    <div x-data="permissionsWizard()" x-init="init()" class="space-y-6">
        <div class="relative rounded-2xl border border-gray-200 bg-gradient-to-br from-white to-gray-50 p-6 shadow-sm">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        Gerenciar permissões
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">Configure permissões por perfil de forma simples e intuitiva.</p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex flex-col items-center gap-2 relative">
                        <div class="relative">
                            <div :class="step >= 1 ? 'bg-gradient-to-br from-indigo-600 to-indigo-700 shadow-lg shadow-indigo-500/50 scale-110' : 'bg-gray-200'"
                                class="flex h-12 w-12 items-center justify-center rounded-full font-bold text-white transition-all duration-300">
                                <span x-show="step > 1" class="text-xl">✓</span>
                                <span x-show="step <= 1">1</span>
                            </div>
                            <div x-show="step === 1"
                                class="absolute inset-0 rounded-full bg-indigo-600 animate-ping opacity-20"></div>
                        </div>
                        <span class="text-xs font-medium"
                            :class="step >= 1 ? 'text-indigo-600' : 'text-gray-500'">Perfil</span>
                    </div>

                    <div class="flex items-center w-12 h-1 rounded-full overflow-hidden bg-gray-200 mb-5">
                        <div :class="step >= 2 ? 'w-full' : 'w-0'"
                            class="h-full bg-gradient-to-r from-indigo-600 to-indigo-700 transition-all duration-500"></div>
                    </div>

                    <div class="flex flex-col items-center gap-2 relative">
                        <div class="relative">
                            <div :class="step >= 2 ? 'bg-gradient-to-br from-indigo-600 to-indigo-700 shadow-lg shadow-indigo-500/50 scale-110' : 'bg-gray-200'"
                                class="flex h-12 w-12 items-center justify-center rounded-full font-bold text-white transition-all duration-300">
                                <span x-show="step > 2" class="text-xl">✓</span>
                                <span x-show="step <= 2">2</span>
                            </div>
                            <div x-show="step === 2"
                                class="absolute inset-0 rounded-full bg-indigo-600 animate-ping opacity-20"></div>
                        </div>
                        <span class="text-xs font-medium"
                            :class="step >= 2 ? 'text-indigo-600' : 'text-gray-500'">Módulos</span>
                    </div>

                    <div class="flex items-center w-12 h-1 rounded-full overflow-hidden bg-gray-200 mb-5">
                        <div :class="step >= 3 ? 'w-full' : 'w-0'"
                            class="h-full bg-gradient-to-r from-indigo-600 to-indigo-700 transition-all duration-500"></div>
                    </div>

                    <div class="flex flex-col items-center gap-2 relative">
                        <div class="relative">
                            <div :class="step >= 3 ? 'bg-gradient-to-br from-indigo-600 to-indigo-700 shadow-lg shadow-indigo-500/50 scale-110' : 'bg-gray-200'"
                                class="flex h-12 w-12 items-center justify-center rounded-full font-bold text-white transition-all duration-300">
                                3
                            </div>
                            <div x-show="step === 3"
                                class="absolute inset-0 rounded-full bg-indigo-600 animate-ping opacity-20"></div>
                        </div>
                        <span class="text-xs font-medium"
                            :class="step >= 3 ? 'text-indigo-600' : 'text-gray-500'">Funcionalidades</span>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="error" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            class="rounded-xl border-2 border-red-200 bg-gradient-to-r from-red-50 to-red-100 px-5 py-4 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="flex-1">
                    <h4 class="font-semibold text-red-800">Erro</h4>
                    <p class="text-sm text-red-700" x-text="error"></p>
                </div>
            </div>
        </div>

        <div x-show="success" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            class="rounded-xl border-2 border-emerald-200 bg-gradient-to-r from-emerald-50 to-emerald-100 px-5 py-4 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="flex-1">
                    <h4 class="font-semibold text-emerald-800">Sucesso</h4>
                    <p class="text-sm text-emerald-700" x-text="success"></p>
                </div>
            </div>
        </div>

        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-8"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            class="rounded-2xl border border-gray-200 bg-white p-8 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        1. Selecione o perfil
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">Escolha o grupo de usuários que deseja configurar</p>
                </div>
                <div x-show="loadingProfiles" class="flex items-center gap-2 text-sm text-indigo-600">
                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>Carregando...</span>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <template x-for="profile in profiles" :key="profile.id">
                    <button type="button"
                        class="group relative overflow-hidden rounded-xl border-2 p-5 text-left transition-all duration-300 hover:scale-105"
                        :class="selectedProfileId === profile.id 
                                                                                                                ? 'border-indigo-500 bg-gradient-to-br from-indigo-50 to-indigo-100 shadow-lg shadow-indigo-200/50' 
                                                                                                                : 'border-gray-200 bg-white hover:border-indigo-300 hover:shadow-md'"
                        @click="selectProfile(profile.id)">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="text-base font-bold text-gray-900" x-text="profile.name"></div>
                                <div class="mt-1 text-xs font-medium text-gray-500">Grupo de acesso</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div :class="selectedProfileId === profile.id ? 'bg-indigo-600 scale-110' : 'bg-gray-200 group-hover:bg-indigo-100'"
                                    class="flex h-10 w-10 items-center justify-center rounded-full transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        :class="selectedProfileId === profile.id ? 'text-white' : 'text-gray-400'"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div x-show="selectedProfileId === profile.id"
                            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-600 to-indigo-700">
                        </div>
                    </button>
                </template>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3">
                <button type="button"
                    class="group inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/50 transition-all duration-300 hover:scale-105 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                    :disabled="!selectedProfileId" @click="step = 2">
                    <span>Continuar</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="step === 2" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-8"
            x-transition:enter-end="opacity-100 transform translate-x-0" x-cloak
            class="rounded-2xl border border-gray-200 bg-white p-8 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        2. Marque os módulos
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Perfil: <span class="font-semibold text-indigo-600" x-text="profileName"></span>
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="rounded-lg border-2 border-indigo-200 bg-indigo-50 px-4 py-2 text-xs font-semibold text-indigo-700 transition-all duration-200 hover:bg-indigo-100 hover:scale-105"
                        @click="selectAllModules()">
                        ✓ Todos
                    </button>
                    <button type="button"
                        class="rounded-lg border-2 border-gray-200 bg-gray-50 px-4 py-2 text-xs font-semibold text-gray-700 transition-all duration-200 hover:bg-gray-100 hover:scale-105"
                        @click="clearAllModules()">
                        ✗ Limpar
                    </button>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <template x-for="module in modules" :key="module.id">
                    <label
                        class="group relative cursor-pointer overflow-hidden rounded-xl border-2 p-5 text-left transition-all duration-300 hover:scale-105"
                        :class="moduleIds.includes(module.id)
                                                            ? 'border-indigo-500 bg-gradient-to-br from-indigo-50 to-indigo-100 shadow-lg shadow-indigo-200/50'
                                                            : 'border-gray-200 bg-white hover:border-indigo-300 hover:shadow-md'">
                        <input type="checkbox" class="sr-only" :value="module.id" x-model.number="moduleIds"
                            @change="syncFunctionalities()">

                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="text-base font-bold text-gray-900" x-text="module.name"></div>
                                <div class="mt-1 text-xs font-medium text-gray-500 truncate" x-text="module.slug"></div>
                            </div>

                            <div class="flex-shrink-0">
                                <div :class="moduleIds.includes(module.id) ? 'bg-indigo-600 scale-110' : 'bg-gray-200 group-hover:bg-indigo-100'"
                                    class="flex h-10 w-10 items-center justify-center rounded-full transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        :class="moduleIds.includes(module.id) ? 'text-white' : 'text-gray-400'" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div x-show="moduleIds.includes(module.id)"
                            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-600 to-indigo-700">
                        </div>
                    </label>
                </template>
            </div>

            <div class="mt-8 flex items-center justify-between gap-3">
                <button type="button"
                    class="group inline-flex items-center gap-2 rounded-xl border-2 border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition-all duration-300 hover:bg-gray-50 hover:scale-105"
                    @click="step = 1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:-translate-x-1"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    <span>Voltar</span>
                </button>
                <button type="button"
                    class="group inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/50 transition-all duration-300 hover:scale-105 hover:shadow-xl"
                    @click="step = 3">
                    <span>Continuar</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="step === 3" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-8"
            x-transition:enter-end="opacity-100 transform translate-x-0" x-cloak
            class="rounded-2xl border border-gray-200 bg-white p-8 shadow-lg">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    3. Marque as funcionalidades
                </h3>
                <p class="mt-1 text-sm text-gray-600">Selecione as funcionalidades específicas de cada módulo</p>
            </div>

            <div x-show="!moduleIds.length"
                class="rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center">
                <div class="text-5xl mb-4">📭</div>
                <p class="text-sm font-medium text-gray-600">Nenhum módulo selecionado</p>
                <p class="mt-1 text-xs text-gray-500">Volte e escolha pelo menos um módulo</p>
            </div>

            <div class="space-y-5" x-show="moduleIds.length">
                <template x-for="module in modules" :key="module.id">
                    <div x-show="moduleIds.includes(module.id)"
                        class="overflow-hidden rounded-xl border-2 border-gray-200 bg-gradient-to-br from-white to-gray-50 shadow-sm transition-all duration-300 hover:shadow-md">
                        <div
                            class="flex items-center justify-between border-b-2 border-gray-200 bg-gradient-to-r from-indigo-50 to-indigo-100 px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600 text-white font-bold shadow">
                                    <span x-text="module.name.charAt(0)"></span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900" x-text="module.name"></div>
                                    <div class="text-xs font-medium text-gray-600" x-text="module.slug"></div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button"
                                    class="rounded-lg border-2 border-indigo-300 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 transition-all duration-200 hover:bg-indigo-100 hover:scale-105"
                                    @click="selectAllFunctionalities(module)">
                                    ✓ Todas
                                </button>
                                <button type="button"
                                    class="rounded-lg border-2 border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 transition-all duration-200 hover:bg-gray-50 hover:scale-105"
                                    @click="clearFunctionalities(module)">
                                    ✗ Limpar
                                </button>
                            </div>
                        </div>

                        <div class="grid gap-3 p-5 sm:grid-cols-2 lg:grid-cols-3">
                            <template x-for="func in module.functionalities" :key="func.id">
                                <label
                                    class="group relative cursor-pointer overflow-hidden rounded-xl border-2 p-4 text-left transition-all duration-300 hover:scale-[1.02]"
                                    :class="functionalityIds.includes(func.id)
                                                                        ? 'border-indigo-500 bg-gradient-to-br from-indigo-50 to-indigo-100 shadow-md shadow-indigo-200/40'
                                                                        : 'border-gray-200 bg-white hover:border-indigo-300 hover:shadow-sm'">
                                    <input type="checkbox" class="sr-only" :value="func.id"
                                        x-model.number="functionalityIds">

                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-bold text-gray-900 leading-tight" x-text="func.name">
                                            </div>
                                            <div class="mt-1 text-xs font-medium text-gray-500 font-mono truncate"
                                                x-text="func.route"></div>
                                        </div>

                                        <div class="flex-shrink-0">
                                            <div :class="functionalityIds.includes(func.id) ? 'bg-indigo-600 scale-110' : 'bg-gray-200 group-hover:bg-indigo-100'"
                                                class="flex h-9 w-9 items-center justify-center rounded-full transition-all duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    :class="functionalityIds.includes(func.id) ? 'text-white' : 'text-gray-400'"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div x-show="functionalityIds.includes(func.id)"
                                        class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-600 to-indigo-700">
                                    </div>
                                </label>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <div class="mt-8 flex items-center justify-between gap-3">
                <button type="button"
                    class="group inline-flex items-center gap-2 rounded-xl border-2 border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition-all duration-300 hover:bg-gray-50 hover:scale-105"
                    @click="step = 2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:-translate-x-1"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    <span>Voltar</span>
                </button>
                <button type="button"
                    class="group inline-flex items-center gap-2 rounded-xl px-6 py-3 text-sm font-semibold text-white shadow-xl transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                    :class="saving ? 'bg-gray-400' : 'bg-gradient-to-r from-emerald-600 to-emerald-700 shadow-emerald-500/50 hover:shadow-2xl'"
                    :disabled="saving" @click="save()">
                    <svg x-show="!saving" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <svg x-show="saving" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span x-text="saving ? 'Salvando...' : 'Salvar permissões'"></span>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function permissionsWizard() {
            return {
                step: 1,
                profiles: [],
                modules: [],
                moduleIds: [],
                functionalityIds: [],
                selectedProfileId: null,
                profileName: '',
                loadingProfiles: false,
                loadingProfile: false,
                saving: false,
                error: '',
                success: '',
                async init() {
                    await this.fetchProfiles();
                },
                async fetchProfiles() {
                    this.loadingProfiles = true;
                    this.error = '';
                    try {
                        const response = await fetch('/system/permissions/profiles');
                        this.profiles = await response.json();
                    } catch (e) {
                        this.error = 'Não foi possível carregar os perfis.';
                    } finally {
                        this.loadingProfiles = false;
                    }
                },
                async selectProfile(id) {
                    if (this.selectedProfileId === id) {
                        this.step = 2;
                        return;
                    }
                    this.selectedProfileId = id;
                    await this.fetchProfile();
                    this.step = 2;
                },
                async fetchProfile() {
                    this.loadingProfile = true;
                    this.error = '';
                    this.success = '';
                    try {
                        const response = await fetch(`/system/permissions/profiles/${this.selectedProfileId}`);
                        const data = await response.json();
                        this.modules = data.modules || [];
                        this.moduleIds = (data.module_ids || []).map(Number);
                        this.functionalityIds = (data.functionality_ids || []).map(Number);
                        this.profileName = data.profile?.name || '';
                        this.syncFunctionalities();
                    } catch (e) {
                        this.error = 'Não foi possível carregar as permissões do perfil.';
                    } finally {
                        this.loadingProfile = false;
                    }
                },
                syncFunctionalities() {
                    const allowed = new Set();
                    this.modules.forEach((module) => {
                        if (this.moduleIds.includes(module.id)) {
                            (module.functionalities || []).forEach(func => allowed.add(func.id));
                        }
                    });
                    this.functionalityIds = this.functionalityIds.filter(id => allowed.has(id));
                },
                selectAllModules() {
                    this.moduleIds = this.modules.map(module => module.id);
                    this.syncFunctionalities();
                },
                clearAllModules() {
                    this.moduleIds = [];
                    this.functionalityIds = [];
                },
                selectAllFunctionalities(module) {
                    const ids = (module.functionalities || []).map(func => func.id);
                    this.functionalityIds = Array.from(new Set([...this.functionalityIds, ...ids]));
                },
                clearFunctionalities(module) {
                    const ids = new Set((module.functionalities || []).map(func => func.id));
                    this.functionalityIds = this.functionalityIds.filter(id => !ids.has(id));
                },
                async save() {
                    if (!this.selectedProfileId) {
                        this.error = 'Selecione um perfil antes de salvar.';
                        this.step = 1;
                        return;
                    }
                    this.saving = true;
                    this.error = '';
                    this.success = '';
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        const response = await fetch(`/system/permissions/profiles/${this.selectedProfileId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token || '',
                            },
                            body: JSON.stringify({
                                module_ids: this.moduleIds,
                                functionality_ids: this.functionalityIds,
                            })
                        });

                        if (!response.ok) {
                            throw new Error('Falha ao salvar');
                        }

                        const data = await response.json();
                        this.success = data.message || 'Permissões atualizadas com sucesso.';
                        window.location.href = '/system/permissions';
                    } catch (e) {
                        this.error = 'Não foi possível salvar as permissões.';
                    } finally {
                        this.saving = false;
                    }
                }
            }
        }
    </script>
@endpush