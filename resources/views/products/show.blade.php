<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-500">Артикул: {{ $product->sku }}</p>
                </div>
            </div>

            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-indigo-50
                      text-indigo-600 border border-indigo-200 hover:border-indigo-300
                      font-semibold text-sm rounded-lg shadow-sm hover:shadow-md
                      transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Назад в каталог
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-linear-to-br from-gray-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

                    <div class="relative bg-linear-to-br from-indigo-900 via-purple-900 to-gray-900 p-8 lg:p-12 flex items-center justify-center min-h-[500px] overflow-hidden">
                        <div class="absolute inset-0 opacity-30">
                            <div class="absolute top-10 left-10 w-40 h-40 bg-indigo-500 rounded-full filter blur-3xl"></div>
                            <div class="absolute bottom-10 right-10 w-40 h-40 bg-purple-500 rounded-full filter blur-3xl"></div>
                            <div class="absolute top-1/2 left-1/2 w-40 h-40 bg-pink-500 rounded-full filter blur-3xl"></div>
                        </div>

                        <div class="relative w-full max-w-md">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-auto rounded-2xl shadow-2xl ring-1 ring-white/20">
                            @else
                                <div class="aspect-square rounded-2xl bg-white/5 backdrop-blur border border-white/10 flex flex-col items-center justify-center">
                                    <svg class="w-24 h-24 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mt-4 text-white/40 text-sm">Изображение отсутствует</p>
                                </div>
                            @endif

                            <div class="absolute -top-3 -left-3 px-4 py-2 bg-linear-to-r from-amber-500 to-orange-500 text-white text-xs font-bold rounded-full shadow-lg uppercase tracking-wider">
                                🔥 Хит продаж
                            </div>
                        </div>
                    </div>

                    <div class="p-8 lg:p-12 flex flex-col">

                        <div class="flex items-center gap-2 mb-3">
                            @if($product->stock > 0)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    В наличии
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-red-700 text-xs font-semibold rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Нет в наличии
                                </span>
                            @endif

                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full">
                                ⚡ Игровая серия
                            </span>
                        </div>

                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">
                            {{ $product->name }}
                        </h1>

                        <div class="mt-6 flex items-baseline gap-3">
                            <span class="text-4xl lg:text-5xl font-extrabold bg-linear-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                {{ number_format((float) $product->price, 0, ',', ' ') }} ₽
                            </span>
                            @if($product->price > 0)
                                <span class="text-lg text-gray-400 line-through">
                                    {{ number_format((float) $product->price * 1.15, 0, ',', ' ') }} ₽
                                </span>
                                <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-md">-15%</span>
                            @endif
                        </div>

                        <div class="mt-6 flex items-center gap-3 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                            Артикул: <span class="font-semibold text-gray-900">{{ $product->sku }}</span>
                        </div>

                        <div class="mt-8 pt-8 border-t border-gray-100">
                            <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Описание
                            </h3>
                            <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                                {{ $product->description ?? 'Мощная игровая система, собранная из топовых комплектующих. Обеспечивает максимальную производительность в современных играх на ультра-настройках.' }}
                            </p>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Процессор</p>
                                    <p class="text-sm font-semibold text-gray-900">Intel / AMD</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Видеокарта</p>
                                    <p class="text-sm font-semibold text-gray-900">RTX Series</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Память</p>
                                    <p class="text-sm font-semibold text-gray-900">16-32 GB</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Накопитель</p>
                                    <p class="text-sm font-semibold text-gray-900">SSD NVMe</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col sm:flex-row gap-3">
                            <button type="button"
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5
                                           bg-linear-to-r from-indigo-600 to-purple-600
                                           hover:from-indigo-700 hover:to-purple-700
                                           text-white font-semibold text-sm rounded-xl shadow-lg shadow-indigo-500/30
                                           hover:shadow-xl hover:shadow-indigo-500/40
                                           transform hover:-translate-y-0.5 active:translate-y-0
                                           transition-all duration-200
                                           disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0
                                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Добавить в корзину
                            </button>

                            <button type="button"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-3.5
                                           bg-white hover:bg-red-50
                                           text-red-600 border border-red-200 hover:border-red-300
                                           font-semibold text-sm rounded-xl shadow-sm hover:shadow-md
                                           transform hover:-translate-y-0.5
                                           transition-all duration-200
                                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </div>

                        <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-gray-500">
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Доставка 1-3 дня
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Гарантия 3 года
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Бесплатная сборка
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h4 class="text-sm font-semibold text-gray-900">Проверено экспертами</h4>
                    <p class="mt-1 text-xs text-gray-500">Каждая система проходит 40+ тестов</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h4 class="text-sm font-semibold text-gray-900">Готов к игре</h4>
                    <p class="mt-1 text-xs text-gray-500">Windows + драйверы предустановлены</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-sm font-semibold text-gray-900">Поддержка 24/7</h4>
                    <p class="mt-1 text-xs text-gray-500">Поможем с настройкой и апгрейдом</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
