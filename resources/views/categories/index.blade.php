<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Каталог') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Заголовок --}}
            <div class="mb-8 text-center sm:text-left">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">
                    Каталог товаров
                </h1>
                <p class="mt-2 text-gray-500">
                    Выберите интересующую вас категорию, чтобы посмотреть товары.
                </p>
            </div>

            @if($categories->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-indigo-50 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Категории пока не добавлены</h3>
                    <p class="mt-1 text-sm text-gray-500">Загляните позже — мы уже готовим ассортимент.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', $category) }}"
                           class="group relative bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                            {{-- Градиентная полоска сверху --}}
                            <div class="h-1.5 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                            <div class="p-6 flex items-center gap-4">
                                <div class="shrink-0 w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center
                                            group-hover:from-indigo-500 group-hover:to-purple-500 transition-colors duration-300">
                                    <svg class="w-7 h-7 text-indigo-600 group-hover:text-white transition-colors duration-300"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 7h18M3 12h18M3 17h18"/>
                                    </svg>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate group-hover:text-indigo-600 transition-colors">
                                        {{ $category->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-0.5">
                                        {{ $category->products_count }}
                                        {{ trans_choice('товар|товара|товаров', $category->products_count) }}
                                    </p>
                                </div>

                                <div class="shrink-0 text-gray-300 group-hover:text-indigo-500 transition-all duration-300 group-hover:translate-x-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Бейдж с количеством --}}
                            <span class="absolute top-4 right-4 inline-flex items-center px-2.5 py-0.5 rounded-full
                                         text-xs font-semibold bg-indigo-50 text-indigo-600
                                         group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                {{ $category->products_count }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
