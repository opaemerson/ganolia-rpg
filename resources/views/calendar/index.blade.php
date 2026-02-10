@extends('system')

@section('title', 'Calendário')
@section('page_title', 'Calendário')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <style>
        .fc-event {
            cursor: pointer !important;
            border-radius: 0.375rem !important;
            border: none !important;
            padding: 2px 6px !important;
            transition: all 0.2s !important;
        }

        .fc-event:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .fc-daygrid-event {
            white-space: normal;
        }

        .fc-button {
            text-transform: capitalize !important;
            font-weight: 500 !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1rem !important;
            transition: all 0.2s !important;
            margin: 0 0.02rem !important;
        }

        .fc-button-group {
            gap: 0.5rem !important;
        }

        .fc-toolbar-chunk {
            display: flex !important;
            gap: 0.75rem !important;
        }

        .fc-toolbar-title {
            font-size: 1.5rem !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
        }

        .fc .fc-button-primary {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
        }

        .fc .fc-button-primary:hover {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .fc .fc-button-primary:disabled {
            background-color: #93c5fd !important;
            border-color: #93c5fd !important;
            cursor: not-allowed !important;
        }

        .fc .fc-button-active {
            background-color: #2563eb !important;
            box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.1) !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        .fc-day-today {
            background-color: rgba(37, 99, 235, 0.05) !important;
        }

        .fc-daygrid-day-number {
            font-weight: 500 !important;
            color: #374151 !important;
        }

        .fc-daygrid-day:hover {
            background-color: rgba(59, 130, 246, 0.02) !important;
        }
    </style>
@endpush

@section('top_actions')
    <div class="flex items-center gap-2">
        <button x-data @click="$dispatch('calendar-open-create')"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Novo Evento
        </button>
    </div>
@endsection

@section('content')
    <div x-data="calendarApp()" x-init="init()" @calendar-open-create.window="openCreateModal()">
        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <select x-model="filters.type" @change="applyFilters()"
                        class="text-sm border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2">
                        <option value="all">Todos os tipos</option>
                        <option value="event">Evento</option>
                        <option value="task">Tarefa</option>
                        <option value="reminder">Lembrete</option>
                        <option value="meeting">Reunião</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <select x-model="filters.status" @change="applyFilters()"
                        class="text-sm border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2">
                        <option value="all">Todos os status</option>
                        <option value="pending">Pendente</option>
                        <option value="done">Concluído</option>
                        <option value="canceled">Cancelado</option>
                    </select>
                </div>

                <div class="flex items-center gap-2 ml-auto">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" x-model="filters.showShared" @change="applyFilters()" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Mostrar compartilhados
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <div id="calendar" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4"></div>

        <div x-show="modalOpen" x-cloak x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4" aria-labelledby="modal-title" role="dialog"
            aria-modal="true" @keydown.escape.window="closeModal()">

            <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" @click="closeModal()"></div>

            <div x-transition:enter="ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative z-10 w-full max-w-2xl bg-white rounded-xl shadow-2xl overflow-hidden">

                <div class="relative bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 px-6 py-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-white"
                                    x-text="modalMode === 'create' ? 'Novo Evento' : 'Editar Evento'"></h3>
                                <p class="text-blue-100 text-sm">Preencha os detalhes do evento</p>
                            </div>
                        </div>
                        <button @click="closeModal()"
                            class="p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-5 max-h-[calc(90vh-200px)] overflow-y-auto custom-scrollbar">
                    <form @submit.prevent="saveEvent()" class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Título <span class="text-red-500">*</span>
                            </label>
                            <input type="text" x-model="currentEvent.title" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                placeholder="Ex: Reunião com cliente">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tipo <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select x-model="currentEvent.type"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 appearance-none bg-white transition-all">
                                        <option value="event">Evento</option>
                                        <option value="task">Tarefa</option>
                                        <option value="reminder">Lembrete</option>
                                        <option value="meeting">Reunião</option>
                                    </select>
                                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <div class="relative">
                                    <select x-model="currentEvent.status"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 appearance-none bg-white transition-all">
                                        <option value="pending">Pendente</option>
                                        <option value="done">Concluído</option>
                                        <option value="canceled">Cancelado</option>
                                    </select>
                                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Início <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" x-model="currentEvent.start" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Término</label>
                                <input type="datetime-local" x-model="currentEvent.end"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" x-model="currentEvent.allDay"
                                    class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all">
                                <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Evento de dia
                                    inteiro</span>
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Descrição</label>
                            <textarea x-model="currentEvent.description" rows="3"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all resize-none"
                                placeholder="Adicione mais detalhes sobre o evento..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Local</label>
                            <div class="relative">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <input type="text" x-model="currentEvent.location"
                                    class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                    placeholder="Ex: Sala de Reuniões A1">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Cor do evento</label>
                            <div class="flex flex-wrap gap-3">
                                <template x-for="color in colorOptions" :key="color.value">
                                    <button type="button" @click="currentEvent.color = color.value"
                                        :style="`background-color: ${color.value}`"
                                        :class="{'ring-4 ring-offset-2': currentEvent.color === color.value}"
                                        class="w-10 h-10 rounded-lg hover:scale-110 active:scale-95 transition-all shadow-md hover:shadow-lg"
                                        :title="color.name">
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-gray-200 space-y-3">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" x-model="currentEvent.notificationEnabled"
                                    class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all">
                                <div class="ml-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500 group-hover:text-blue-600 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Ativar
                                        notificações</span>
                                </div>
                            </label>
                            <div x-show="currentEvent.notificationEnabled" x-transition
                                class="ml-8 pt-2 border-t border-gray-100">
                                <label class="block text-sm text-gray-600 mb-2">Notificar antes (minutos)</label>
                                <input type="number" x-model="currentEvent.notificationMinutesBefore" min="0"
                                    class="w-32 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm transition-all">
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-gray-200 space-y-3">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" x-model="currentEvent.isShared"
                                    class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all">
                                <div class="ml-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500 group-hover:text-blue-600 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Compartilhar
                                        evento</span>
                                </div>
                            </label>
                            <div x-show="currentEvent.isShared" x-transition
                                class="ml-8 pt-2 border-t border-gray-100 space-y-2">
                                <label class="block text-sm text-gray-600 mb-2">Compartilhar com:</label>
                                <select multiple x-model="currentEvent.sharedWithUsers"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm transition-all"
                                    size="4">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->login }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500">Segure Ctrl/Cmd para selecionar múltiplos usuários</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Recorrência (RRULE)
                            </label>
                            <input type="text" x-model="currentEvent.recurrenceRule"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm transition-all"
                                placeholder="Ex: FREQ=DAILY;COUNT=5">
                            <p class="text-xs text-gray-500 mt-2">Formato: FREQ=DAILY/WEEKLY/MONTHLY;COUNT=n ou UNTIL=data
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Notas adicionais
                            </label>
                            <textarea x-model="currentEvent.notes" rows="2"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm transition-all resize-none"
                                placeholder="Adicione observações extras..."></textarea>
                        </div>
                    </form>
                </div>

                <div
                    class="bg-white border-t border-gray-200 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-between gap-3">
                    <div>
                        <button x-show="modalMode === 'edit'" @click="deleteEvent()" type="button"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Excluir
                        </button>
                    </div>
                    <div class="flex gap-2">
                        <button @click="closeModal()" type="button"
                            class="flex-1 sm:flex-none px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500/20 transition-all">
                            Cancelar
                        </button>
                        <button @click="saveEvent()" type="button"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 shadow-lg shadow-blue-500/30 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Salvar evento
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const flashMessage = sessionStorage.getItem('flashMessage');
            if (flashMessage) {
                const { type, message } = JSON.parse(flashMessage);
                sessionStorage.removeItem('flashMessage');

                const alertDiv = document.createElement('div');
                alertDiv.className = 'fixed top-4 right-4 z-50 max-w-sm';

                const colorClasses = {
                    success: 'border-emerald-200 bg-white',
                    error: 'border-red-200 bg-white',
                    info: 'border-sky-200 bg-white',
                    warning: 'border-amber-200 bg-white'
                };

                const iconColors = {
                    success: 'bg-emerald-600',
                    error: 'bg-red-600',
                    info: 'bg-sky-600',
                    warning: 'bg-amber-600'
                };

                const icons = {
                    success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />',
                    error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />',
                    info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />',
                    warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.5 20h15a2 2 0 001.71-3.14l-7.5-13a2 2 0 00-3.42 0z" />'
                };

                const titles = {
                    success: 'Sucesso',
                    error: 'Erro',
                    info: 'Info',
                    warning: 'Atenção'
                };

                alertDiv.innerHTML = `
                                                                    <div class="overflow-hidden rounded-2xl border ${colorClasses[type] || colorClasses.info} shadow-lg">
                                                                        <div class="flex items-start gap-3 p-4">
                                                                            <div class="flex h-10 w-10 items-center justify-center rounded-xl ${iconColors[type] || iconColors.info} text-white shadow-sm">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                    ${icons[type] || icons.info}
                                                                                </svg>
                                                                            </div>
                                                                            <div class="min-w-0 flex-1">
                                                                                <p class="text-sm font-semibold text-gray-900">${titles[type] || titles.info}</p>
                                                                                <p class="mt-0.5 text-sm text-gray-700">${message}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                `;

                document.body.appendChild(alertDiv);

                setTimeout(() => {
                    alertDiv.style.opacity = '0';
                    alertDiv.style.transition = 'opacity 0.3s';
                    setTimeout(() => alertDiv.remove(), 300);
                }, 5000);
            }
        });

        function calendarApp() {
            const emptyEvent = () => ({
                id: null,
                title: '',
                description: '',
                type: 'event',
                start: '',
                end: '',
                allDay: false,
                color: '#3b82f6',
                status: 'pending',
                location: '',
                notes: '',
                notificationEnabled: false,
                notificationMinutesBefore: 15,
                isShared: false,
                sharedWithUsers: [],
                recurrenceRule: '',
            });

            return {
                calendar: null,
                modalOpen: false,
                modalMode: 'create',
                currentEvent: emptyEvent(),
                filters: {
                    type: 'all',
                    status: 'all',
                    showShared: true
                },
                getEmptyEvent: emptyEvent,
                colorOptions: [
                    { value: '#3b82f6', name: 'Azul' },
                    { value: '#10b981', name: 'Verde' },
                    { value: '#f59e0b', name: 'Laranja' },
                    { value: '#8b5cf6', name: 'Roxo' },
                    { value: '#ef4444', name: 'Vermelho' },
                    { value: '#ec4899', name: 'Rosa' },
                    { value: '#06b6d4', name: 'Ciano' },
                    { value: '#6b7280', name: 'Cinza' },
                ],

                init() {
                    this.initCalendar();
                },

                initCalendar() {
                    const calendarEl = document.getElementById('calendar');
                    this.calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        locale: 'pt-br',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                        },
                        buttonText: {
                            today: 'Hoje',
                            month: 'Mês',
                            week: 'Semana',
                            day: 'Dia',
                            list: 'Lista'
                        },
                        events: (info, successCallback, failureCallback) => {
                            this.fetchEvents(info, successCallback, failureCallback);
                        },
                        eventClick: (info) => {
                            this.openEditModal(info.event);
                        },
                        dateClick: (info) => {
                            this.openCreateModal(info.dateStr);
                        },
                        eventDrop: (info) => {
                            this.updateEventDates(info.event);
                        },
                        eventResize: (info) => {
                            this.updateEventDates(info.event);
                        },
                        editable: true,
                        selectable: true,
                        selectMirror: true,
                        dayMaxEvents: true,
                        height: 'auto',
                    });
                    this.calendar.render();
                },

                fetchEvents(info, successCallback, failureCallback) {
                    let url = '/calendar/events?start=' + info.startStr + '&end=' + info.endStr;

                    if (this.filters.type !== 'all') {
                        url += '&type=' + this.filters.type;
                    }
                    if (this.filters.status !== 'all') {
                        url += '&status=' + this.filters.status;
                    }

                    fetch(url, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(events => {
                            if (!this.filters.showShared) {
                                events = events.filter(e => e.extendedProps.isOwner);
                            }
                            successCallback(events);
                        })
                        .catch(error => {
                            console.error('Erro ao carregar eventos:', error);
                            failureCallback(error);
                        });
                },

                applyFilters() {
                    this.calendar.refetchEvents();
                },

                openCreateModal(dateStr = null) {
                    this.modalMode = 'create';
                    this.currentEvent = this.getEmptyEvent();

                    if (dateStr) {
                        this.currentEvent.start = dateStr + 'T09:00';
                        this.currentEvent.end = dateStr + 'T10:00';
                    }

                    this.modalOpen = true;
                },

                openEditModal(event) {
                    this.modalMode = 'edit';

                    if (!event.extendedProps.isOwner) {
                        alert('Você não tem permissão para editar este evento.');
                        return;
                    }

                    this.currentEvent = {
                        id: event.id,
                        title: event.title,
                        description: event.extendedProps.description || '',
                        type: event.extendedProps.type || 'event',
                        start: this.formatDateTimeLocal(event.start),
                        end: event.end ? this.formatDateTimeLocal(event.end) : '',
                        allDay: event.allDay || false,
                        color: event.backgroundColor || '#3b82f6',
                        status: event.extendedProps.status || 'pending',
                        location: event.extendedProps.location || '',
                        notes: event.extendedProps.notes || '',
                        notificationEnabled: event.extendedProps.notificationEnabled || false,
                        notificationMinutesBefore: event.extendedProps.notificationMinutesBefore || 15,
                        isShared: event.extendedProps.isShared || false,
                        sharedWithUsers: event.extendedProps.sharedWithUsers || [],
                        recurrenceRule: event.extendedProps.recurrenceRule || '',
                    };

                    this.modalOpen = true;
                },

                closeModal() {
                    this.modalOpen = false;
                    this.currentEvent = this.getEmptyEvent();
                },

                async saveEvent() {
                    const url = this.modalMode === 'create'
                        ? '/calendar/events'
                        : `/calendar/events/${this.currentEvent.id}`;

                    const method = this.modalMode === 'create' ? 'POST' : 'PUT';

                    try {
                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.currentEvent)
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            sessionStorage.setItem('flashMessage', JSON.stringify({
                                type: 'success',
                                message: data.message
                            }));
                            window.location.reload();
                        } else {
                            alert('Erro ao salvar evento: ' + (data.message || 'Erro desconhecido'));
                        }
                    } catch (error) {
                        console.error('Erro:', error);
                        alert('Erro ao salvar evento');
                    }
                },

                async deleteEvent() {
                    if (!confirm('Tem certeza que deseja excluir este evento?')) {
                        return;
                    }

                    try {
                        const response = await fetch(`/calendar/events/${this.currentEvent.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            sessionStorage.setItem('flashMessage', JSON.stringify({
                                type: 'success',
                                message: data.message
                            }));
                            window.location.reload();
                        } else {
                            alert('Erro ao excluir evento');
                        }
                    } catch (error) {
                        console.error('Erro:', error);
                        alert('Erro ao excluir evento');
                    }
                },

                async updateEventDates(event) {
                    try {
                        const response = await fetch(`/calendar/events/${event.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                start: event.start.toISOString(),
                                end: event.end ? event.end.toISOString() : null,
                            })
                        });

                        if (!response.ok) {
                            event.revert();
                            this.showNotification('Erro ao atualizar evento', 'error');
                        }
                    } catch (error) {
                        console.error('Erro:', error);
                        event.revert();
                        this.showNotification('Erro ao atualizar evento', 'error');
                    }
                },

                formatDateTimeLocal(date) {
                    if (!date) return '';
                    const d = new Date(date);
                    const year = d.getFullYear();
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    const hours = String(d.getHours()).padStart(2, '0');
                    const minutes = String(d.getMinutes()).padStart(2, '0');
                    return `${year}-${month}-${day}T${hours}:${minutes}`;
                },

                showNotification(message, type = 'info') {
                    console.log(message, type);
                }
            };
        }
    </script>
@endpush