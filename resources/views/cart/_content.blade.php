<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">Корзина</h1>
            <p class="mt-2 text-gray-500">Проверьте состав заказа перед оформлением.</p>
        </div>

        @if(count($items) === 0)
            {{-- Пустая корзина --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="mx-auto w-20 h-20 rounded-full bg-indigo-50 flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 4.6A1 1 0 005.6 19H19M9 22a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Ваша корзина пуста</h3>
                <p class="mt-1 text-sm text-gray-500">Добавьте товары из каталога, чтобы оформить заказ.</p>
                <a href="{{ route('products.index') }}"
                   class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                          bg-indigo-600 text-white text-sm font-semibold
                          hover:bg-indigo-700 active:bg-indigo-800
                          shadow-sm hover:shadow-md transition-all">
                    Перейти в каталог
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-4">
                    @foreach($items as $item)
                        @php $product = $item['product']; @endphp

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow p-4 sm:p-5">
                            <div class="flex items-start gap-4">

                                {{-- Изображение --}}
                                <div class="shrink-0 w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-gray-50 overflow-hidden flex items-center justify-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 truncate">
                                                {{ $product->name }}
                                            </h3>
                                            @if($product->sku)
                                                <p class="text-sm text-gray-500 mt-0.5">Артикул: {{ $product->sku }}</p>
                                            @endif
                                            <p class="text-sm text-gray-500 mt-1">
                                                Цена: <span class="font-medium text-gray-700">{{ number_format((float) $item['unit_price'], 0, '.', ' ') }} ₽</span>
                                            </p>
                                        </div>

                                        <form action="{{ route('cart.items.destroy', $product) }}" method="POST" data-ajax-cart class="shrink-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                                    title="Удалить">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="mt-3 flex items-center justify-between gap-3 flex-wrap">
                                        {{-- Счётчик --}}
                                        <form action="{{ route('cart.items.update', $product) }}" method="POST"
                                              data-ajax-cart
                                              data-cart-action="set"
                                              class="inline-flex items-center rounded-xl border border-gray-200 bg-gray-50 overflow-hidden">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}"
                                                    class="w-9 h-9 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                </svg>
                                            </button>

                                            <input type="text" value="{{ $item['quantity'] }}" readonly
                                                   class="w-10 h-9 text-center bg-white border-x border-gray-200 text-sm font-semibold text-gray-900 focus:outline-none">

                                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                                    class="w-9 h-9 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </button>
                                        </form>

                                        {{-- товар --}}
                                        <form ... data-ajax-cart data-toast="Товар добавлен в корзину">

                                            {{-- удалить --}}
                                            <form ... data-ajax-cart data-toast="Товар удалён">

                                                {{-- счётчик --}}
                                                <form ... data-ajax-cart data-cart-action="set" data-toast="Количество обновлено">

                                                    {{-- очистить --}}
                                                    <form ... data-ajax-cart data-toast="Корзина очищена">
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-gray-900">
                                                {{ number_format((float) $item['subtotal'], 0, '.', ' ') }} ₽
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-end">
                        <form action="{{ route('cart.clear') }}" method="POST" data-ajax-cart>
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition-colors">
                                Очистить корзину
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Итого</h2>

                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Товары ({{ $totalQuantity }})</dt>
                                <dd class="font-medium text-gray-900">
                                    {{ number_format((float) $totalPrice, 0, '.', ' ') }} ₽
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Доставка</dt>
                                <dd class="font-medium text-gray-900">—</dd>
                            </div>
                        </dl>

                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-baseline">
                            <span class="text-base font-semibold text-gray-900">К оплате</span>
                            <span class="text-2xl font-bold text-gray-900">
                {{ number_format((float) $totalPrice, 0, '.', ' ') }} ₽
            </span>
                        </div>

                        {{-- Форма оформления заказа --}}
                        <form method="POST" action="{{ route('orders.store') }}" class="mt-6">
                            @csrf

                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Способ оплаты</h3>

                            <div class="space-y-2">
                                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200
                              hover:border-indigo-300 hover:bg-indigo-50/50
                              cursor-pointer transition-colors">
                                    <input type="radio"
                                           name="payment_method"
                                           value="cash"
                                           class="text-indigo-600 focus:ring-indigo-500"
                                        @checked(old('payment_method', 'cash') === 'cash')>
                                    <span class="text-sm text-gray-700">Наличными при получении</span>
                                </label>

                                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200
                              hover:border-indigo-300 hover:bg-indigo-50/50
                              cursor-pointer transition-colors">
                                    <input type="radio"
                                           name="payment_method"
                                           value="card"
                                           class="text-indigo-600 focus:ring-indigo-500"
                                        @checked(old('payment_method') === 'card')>
                                    <span class="text-sm text-gray-700">Картой при получении</span>
                                </label>
                            </div>

                            <button type="submit"
                                    class="mt-5 w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl
                           bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold
                           hover:from-indigo-700 hover:to-purple-700
                           shadow-sm hover:shadow-lg transition-all">
                                Оформить заказ
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </form>

                        <a href="{{ route('products.index') }}"
                           class="mt-3 w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl
                  bg-gray-50 text-gray-700 text-sm font-medium
                  hover:bg-gray-100 transition-colors">
                            Продолжить покупки
                        </a>
                    </div>
                </div>
        @endif

    </div>
</div>
