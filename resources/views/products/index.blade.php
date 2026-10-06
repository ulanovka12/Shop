@php($perPage = $dto->per_page ?? 10)
@php($q = $dto->q ?? '')
@php($minPrice = $dto->min_price ?? '')
@php($maxPrice = $dto->max_price ?? '')
@php($inStock = $dto->in_stock ?? false)
@php($sort = $dto->sort ?? 'new')
@php($maxProductPricePlaceholder = $maxProductPrice ? ('до ' . $maxProductPrice) : 'макс. цена')

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight">Каталог товаров</h2>
                    <p class="text-sm text-gray-500">Найдено товаров: {{ $products->total() }}</p>
                </div>
            </div>

            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-indigo-50
                      text-indigo-600 border border-indigo-200 hover:border-indigo-300
                      font-semibold text-sm rounded-lg shadow-sm hover:shadow-md
                      transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
                </svg>
                На главную
            </a>

            <a href="{{ route('cart.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-indigo-50
                      text-indigo-600 border border-indigo-200 hover:border-indigo-300
                      font-semibold text-sm rounded-lg shadow-sm hover:shadow-md
                      transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
                </svg>
                Моя Корзина
            </a>

            <a href="{{ route('orders.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-indigo-50
                      text-indigo-600 border border-indigo-200 hover:border-indigo-300
                      font-semibold text-sm rounded-lg shadow-sm hover:shadow-md
                      transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
                </svg>
                Мои заказы
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-linear-to-br from-gray-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if($errors->any())
                <div class="p-4 rounded-2xl bg-red-50 border border-red-200 flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-sm font-medium text-red-800">{{ $errors->first() }}</p>
                </div>
            @endif

            @if(isset($categories) && $categories->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-5 sm:p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Категории</h3>
                                <p class="text-xs text-gray-500">Выберите категорию товаров</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($categories as $cat)
                                @php($active = isset($category) && $category->id === $cat->id)
                                <a href="{{ route('categories.show', $cat) }}"
                                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-medium
                          border transition-all duration-200
                          {{ $active
                              ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white border-transparent shadow-md'
                              : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-indigo-50 hover:border-indigo-300 hover:text-indigo-700' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="inline-flex items-center justify-center min-w-[1.5rem] h-6 px-1.5 rounded-full text-xs font-bold
                                 {{ $active ? 'bg-white/20 text-white' : 'bg-white text-gray-600 border border-gray-200' }}">
                        {{ $cat->products_count }}
                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Фильтры</h3>
                        <p class="text-xs text-gray-500">Уточните параметры поиска</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('products.index') }}" class="p-5 sm:p-6 space-y-5">

                    <div>
                        <label for="q" class="block text-sm font-semibold text-gray-700 mb-2">Поиск</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text"
                                   name="q"
                                   id="q"
                                   value="{{ $q }}"
                                   placeholder="Название или артикул"
                                   class="block w-full pl-11 pr-4 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl
                                          placeholder:text-gray-400
                                          focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none
                                          transition-all duration-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                        <div>
                            <label for="min_price" class="block text-sm font-semibold text-gray-700 mb-2">Цена от</label>
                            <div class="relative">
                                <input type="number"
                                       name="min_price"
                                       id="min_price"
                                       value="{{ $minPrice }}"
                                       placeholder="от 100"
                                       min="0"
                                       step="100"
                                       class="block w-full pl-4 pr-10 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl
                                              placeholder:text-gray-400
                                              focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none
                                              transition-all duration-200">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                                    <span class="text-sm text-gray-400 font-medium">₽</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="max_price" class="block text-sm font-semibold text-gray-700 mb-2">Цена до</label>
                            <div class="relative">
                                <input type="number"
                                       name="max_price"
                                       id="max_price"
                                       value="{{ $maxPrice }}"
                                       placeholder="{{ $maxProductPricePlaceholder }}"
                                       min="0"
                                       step="100"
                                       class="block w-full pl-4 pr-10 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl
                                              placeholder:text-gray-400
                                              focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none
                                              transition-all duration-200">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                                    <span class="text-sm text-gray-400 font-medium">₽</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="sort" class="block text-sm font-semibold text-gray-700 mb-2">Сортировка</label>
                            <select name="sort" id="sort"
                                    class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl
                                           focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none
                                           transition-all duration-200 cursor-pointer">
                                <option value="new" @selected($sort === 'new')>Сначала новые</option>
                                <option value="price_asc" @selected($sort === 'price_asc')>Цена: по возрастанию</option>
                                <option value="price_desc" @selected($sort === 'price_desc')>Цена: по убыванию</option>
                                <option value="name_asc" @selected($sort === 'name_asc')>Название: А → Я</option>
                                <option value="name_desc" @selected($sort === 'name_desc')>Название: Я → А</option>
                                <option value="stock_desc" @selected($sort === 'stock_desc')>Наличие: больше → меньше</option>
                                <option value="stock_asc" @selected($sort === 'stock_asc')>Наличие: меньше → больше</option>
                            </select>
                        </div>

                        <div>
                            <label for="per_page" class="block text-sm font-semibold text-gray-700 mb-2">На странице</label>
                            <select name="per_page" id="per_page"
                                    class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl
                                           focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none
                                           transition-all duration-200 cursor-pointer">
                                @foreach([10, 25, 50, 100] as $option)
                                    <option value="{{ $option }}" @selected($perPage == $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-100">

                        <label for="in_stock" class="inline-flex items-center gap-2.5 cursor-pointer select-none">
                            <input type="checkbox"
                                   name="in_stock"
                                   id="in_stock"
                                   value="1"
                                   @checked($inStock)
                                   class="w-4 h-4 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 cursor-pointer">
                            <span class="text-sm font-medium text-gray-700">Только в наличии</span>
                        </label>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('products.index', ['per_page' => $perPage]) }}"
                               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-gray-50
                                      text-gray-700 border border-gray-300 hover:border-gray-400
                                      font-semibold text-sm rounded-lg shadow-sm hover:shadow-md
                                      transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Сбросить
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5
                                           bg-linear-to-r from-indigo-600 to-purple-600
                                           hover:from-indigo-700 hover:to-purple-700
                                           text-white font-semibold text-sm rounded-lg shadow-md hover:shadow-lg
                                           transform hover:-translate-y-0.5 transition-all duration-200
                                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Применить
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden
                                    hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">

                            <div class="relative aspect-square overflow-hidden bg-gray-100">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif

                                @if($product->stock <= 0)
                                    <div class="absolute top-3 left-3 px-2.5 py-1 bg-red-500 text-white text-[10px] font-bold rounded-full uppercase tracking-wider shadow-lg">
                                        Нет в наличии
                                    </div>
                                @elseif($product->stock <= 5)
                                    <div class="absolute top-3 left-3 px-2.5 py-1 bg-amber-500 text-white text-[10px] font-bold rounded-full uppercase tracking-wider shadow-lg">
                                        Осталось {{ $product->stock }}
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 flex flex-col flex-1">
                                <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 min-h-[2.5rem]">
                                    {{ $product->name }}
                                </h3>

                                <p class="mt-2 text-lg font-bold bg-linear-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                    {{ number_format($product->price, 0, ',', ' ') }} ₽
                                </p>

                                @php($detailsUrl = Route::has('products.show') ? route('products.show', $product) : '#')
                                    <a href="{{ $detailsUrl }}"
                                       class="mt-4 inline-flex items-center justify-center gap-2 px-4 py-2.5
                                          bg-linear-to-r from-indigo-600 to-purple-600
                                          hover:from-indigo-700 hover:to-purple-700
                                          text-white font-semibold text-sm rounded-lg shadow-md hover:shadow-lg
                                          transform hover:-translate-y-0.5 transition-all duration-200
                                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Подробнее
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links('pagination::tailwind') }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                    <div class="w-20 h-20 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Ничего не найдено</h3>
                    <p class="mt-1 text-sm text-gray-500">Попробуйте изменить условия поиска или сбросить фильтры</p>

                    <a href="{{ route('products.index') }}"
                       class="mt-6 inline-flex items-center gap-2 px-5 py-2.5
                              bg-linear-to-r from-indigo-600 to-purple-600
                              hover:from-indigo-700 hover:to-purple-700
                              text-white font-semibold text-sm rounded-lg shadow-md hover:shadow-lg
                              transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Сбросить фильтры
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
