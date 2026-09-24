@extends('layouts.app')

@section('title', 'Каталог товаров')

@section('content')

    @php($perPage = $products->perPage())


    <div class="min-h-screen bg-linear-to-br from-gray-50 to-indigo-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Каталог товаров</h1>
                        <p class="text-sm text-gray-500">Всего найдено: {{ $products->total() }}</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-2">
                    <label for="per_page" class="text-sm font-medium text-gray-600 whitespace-nowrap">
                        На странице:
                    </label>
                    <select name="per_page"
                            id="per_page"
                            onchange="this.form.submit()"
                            class="text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-3 py-2
                                   focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none
                                   transition-all duration-200 cursor-pointer">
                        @foreach([10, 25, 50, 100] as $option)
                            <option value="{{ $option }}" @selected($perPage == $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden
                                    hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">

                            <div class="relative overflow-hidden bg-gray-100" style="height: 200px;">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         style="width: 100%; height: 100%; object-fit: cover; object-position: center;"
                                         class="group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 flex flex-col flex-1">
                                <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 min-h-[2.5rem]">
                                    {{ $product->name }}
                                </h3>

                                <p class="mt-2 text-lg font-bold text-indigo-600">
                                    {{ Number::currency((float) $product->price, 'RUB', 'ru') }}
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Товары ещё не добавлены</h3>
                    <p class="mt-1 text-sm text-gray-500">Как только появятся первые товары, они отобразятся здесь</p>
                </div>
            @endif

        </div>
    </div>
@endsection
