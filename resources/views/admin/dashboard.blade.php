<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900">Админ-панель</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="rounded-3xl shadow-lg p-8 text-white relative overflow-hidden"
                 style="background: linear-gradient(90deg, #1e3a8a 0%, #3730a3 50%, #1e3a8a 100%);">
                <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-16 -right-4 w-40 h-40 rounded-full bg-white/5"></div>

                <div class="relative">
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">
                        Добро пожаловать, {{ auth()->user()->name ?? 'админ' }}
                    </h1>
                    <p class="mt-2 text-blue-100 text-sm sm:text-base">
                        Вот краткая сводка по вашему магазину на сегодня.
                    </p>
                </div>
            </div>

            {{-- Счётчики --}}
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Обзор</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    {{-- Заказы --}}
                    <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Всего заказов</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">
                                    {{ \App\Models\Order::count() }}
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center
                                        group-hover:bg-indigo-600 transition-colors">
                                <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Выручка --}}
                    <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6">
                        <div class="flex items-start justify-between">
                            <div class="min-w-0">
                                <p class="text-sm text-gray-500">Выручка (оплачено)</p>
                                <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-2 truncate">
                                    {{ number_format((float) \App\Models\Order::where('status', 'paid')->sum('total'), 0, ',', ' ') }} ₽
                                </p>
                            </div>
                            <div class="shrink-0 w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center
                                        group-hover:bg-emerald-600 transition-colors">
                                <svg class="w-6 h-6 text-emerald-600 group-hover:text-white transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Пользователи --}}
                    <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Пользователей</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">
                                    {{ \App\Models\User::count() }}
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center
                                        group-hover:bg-sky-600 transition-colors">
                                <svg class="w-6 h-6 text-sky-600 group-hover:text-white transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 0a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Товары --}}
                    <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Товаров</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">
                                    {{ \App\Models\Product::count() }}
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center
                                        group-hover:bg-amber-500 transition-colors">
                                <svg class="w-6 h-6 text-amber-500 group-hover:text-white transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Быстрые ссылки --}}
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Управление</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <a href="{{ route('admin.roles.index') }}"
                       class="group relative bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 overflow-hidden">
                        <div class="h-1.5 w-full absolute top-0 left-0 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

                        <div class="flex items-start gap-4">
                            <div class="shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center
                                        group-hover:from-indigo-500 group-hover:to-purple-500 transition-colors duration-300">
                                <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors duration-300"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                    Роли
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Управление ролями пользователей
                                </p>
                            </div>

                            <div class="shrink-0 text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
