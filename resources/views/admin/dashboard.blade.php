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

                    {{-- Заказы (за последние 7 дней) --}}
                    <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Заказов (7 дней)</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">
                                    {{ $report['orders_count'] }}
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-600 transition-colors">
                                <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Выручка --}}
                    <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6">
                        <div class="flex items-start justify-between">
                            <div class="min-w-0">
                                <p class="text-sm text-gray-500">Выручка (успешные)</p>
                                <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-2 truncate" title="{{ number_format($report['revenue'], 2, '.', ' ') }} ₽">
                                    {{ number_format($report['revenue'], 0, ',', ' ') }} ₽
                                </p>
                            </div>
                            <div class="shrink-0 w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-600 transition-colors">
                                <svg class="w-6 h-6 text-emerald-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Успешные продажи --}}
                    <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Успешных продаж</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">
                                    {{ $report['sales_count'] }}
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center group-hover:bg-sky-600 transition-colors">
                                <svg class="w-6 h-6 text-sky-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Отмененные --}}
                    <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Отменено</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">
                                    {{ $report['canceled_count'] }}
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center group-hover:bg-red-600 transition-colors">
                                <svg class="w-6 h-6 text-red-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Детализация по дням --}}
            <div>
                <div class="flex justify-between items-end mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Продажи за последнюю неделю</h2>
                    @if($report['calculated_at'])
                        <span class="text-xs text-gray-500">Обновлено: {{ \Carbon\Carbon::parse($report['calculated_at'])->format('H:i') }}</span>
                    @endif
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Дата</th>
                            <th class="px-6 py-4 text-center">Продаж</th>
                            <th class="px-6 py-4 text-right">Выручка</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        {{-- Теперь мы итерируем коллекцию моделей DailySalesReport --}}
                        @forelse ($report['daily_reports'] as $day)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                    {{ $day->report_date->format('d.m.Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-center font-semibold {{ $day->sales_count > 0 ? 'text-gray-900' : 'text-gray-400' }}">
                                    {{ $day->sales_count }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right font-bold {{ $day->revenue > 0 ? 'text-emerald-600' : 'text-gray-400' }}">
                                    {{ number_format((float) $day->revenue, 2, '.', ' ') }} ₽
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    Данных пока нет. Дождитесь выполнения фоновой задачи.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Быстрые ссылки --}}
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Управление</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                    <!-- 1. Платежи YooKassa -->
                    <a href="{{ route('admin.payments.index') }}"
                       class="group relative bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 overflow-hidden">
                        <div class="h-1.5 w-full absolute top-0 left-0 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                        <div class="flex items-start gap-4">
                            <div class="shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center group-hover:from-indigo-500 group-hover:to-purple-500 transition-colors duration-300">
                                <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">Платежи</h3>
                                <p class="text-sm text-gray-500 mt-1">История транзакций</p>
                            </div>
                            <div class="shrink-0 text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </a>

                    <!-- 2. Роли -->
                    <a href="{{ route('admin.roles.index') }}"
                       class="group relative bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 overflow-hidden">
                        <div class="h-1.5 w-full absolute top-0 left-0 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                        <div class="flex items-start gap-4">
                            <div class="shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center group-hover:from-indigo-500 group-hover:to-purple-500 transition-colors duration-300">
                                <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">Роли</h3>
                                <p class="text-sm text-gray-500 mt-1">Управление доступами</p>
                            </div>
                            <div class="shrink-0 text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </a>

                    <!-- 3. Категории -->
                    <a href="{{ route('admin.products.index') }}"
                       class="group relative bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 overflow-hidden">
                        <div class="h-1.5 w-full absolute top-0 left-0 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                        <div class="flex items-start gap-4">
                            <div class="shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center group-hover:from-indigo-500 group-hover:to-purple-500 transition-colors duration-300">
                                <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">Категории</h3>
                                <p class="text-sm text-gray-500 mt-1">Управление каталогом</p>
                            </div>
                            <div class="shrink-0 text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </a>

                    <!-- 4. Создание товаров -->
                    <a href="{{ route('admin.products.create') }}"
                       class="group relative bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 overflow-hidden">
                        <div class="h-1.5 w-full absolute top-0 left-0 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                        <div class="flex items-start gap-4">
                            <div class="shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center group-hover:from-indigo-500 group-hover:to-purple-500 transition-colors duration-300">
                                <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">Создать товар</h3>
                                <p class="text-sm text-gray-500 mt-1">Добавление в каталог</p>
                            </div>
                            <div class="shrink-0 text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
