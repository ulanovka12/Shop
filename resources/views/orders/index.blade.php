<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Мои заказы
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-red-100 text-red-800 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="bg-white shadow-sm sm:rounded-lg p-10 text-center">
                    <div class="text-5xl mb-3">📦</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">У вас пока нет заказов</h3>
                    <p class="text-gray-500">Оформите первый заказ — и он появится в этом списке.</p>
                </div>
            @else
                <p class="text-sm text-gray-500">Всего заказов: {{ $orders->count() }}</p>

                @foreach($orders as $order)
                    @php
                        $statusColor = match ($order->status) {
                            \App\Models\Order::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
                            \App\Models\Order::STATUS_CANCELED => 'bg-red-100 text-red-800',
                            \App\Models\Order::STATUS_PAID => 'bg-green-100 text-green-800',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp

                    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden mb-6">
                        {{-- Шапка карточки заказа --}}
                        <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap justify-between items-center gap-2 bg-gray-50/50">
                            <div>
                                <div class="font-semibold text-gray-800">Заказ #{{ $order->id }}</div>
                                <div class="text-sm text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                {{ $order->status_label }}
                            </span>
                        </div>

                        {{-- Тело карточки заказа --}}
                        <div class="p-6">
                            {{-- Сводка --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase mb-1">Сумма</div>
                                    <div class="text-lg font-bold text-gray-900">
                                        {{ number_format((float) $order->total, 0, ',', ' ') }} ₽
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase mb-1">Оплата</div>
                                    <div class="text-gray-800">{{ $order->payment_method_label }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase mb-1">Адрес</div>
                                    <div class="text-gray-800">{{ $order->shipping_address ?? '—' }}</div>
                                </div>
                            </div>

                            {{-- Состав заказа --}}
                            <div class="border border-gray-200 rounded-lg overflow-hidden mb-4 divide-y divide-gray-100">
                                @foreach($order->items as $item)
                                    <div class="px-4 py-3 flex justify-between items-center gap-3">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="truncate text-gray-800">
                                                {{ $item->product?->name ?? 'Товар удален' }}
                                            </span>
                                            <span class="shrink-0 px-2 py-0.5 rounded text-xs text-gray-600 bg-gray-100">
                                                × {{ $item->quantity }}
                                            </span>
                                        </div>
                                        <div class="font-semibold text-gray-900 whitespace-nowrap">
                                            {{ number_format((float) $item->price, 0, ',', ' ') }} ₽
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- БЛОК ОПЛАТЫ ЮKASSA --}}
                            @if($order->payment_method === \App\Models\Order::PAYMENT_METHOD_YOOKASSA && $order->status !== \App\Models\Order::STATUS_PAID)
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Детали онлайн-платежа</h4>

                                    @if($order->latestPayment)
                                        {{-- Статус последнего платежа --}}
                                        <p class="text-sm text-gray-600 mb-3">
                                            Статус:
                                            <span class="font-semibold
                                                @if($order->latestPayment->status === 'succeeded') text-green-600
                                                @elseif($order->latestPayment->status === 'canceled') text-red-600
                                                @else text-yellow-600 @endif">
                                                {{ match($order->latestPayment->status) {
                                                    'pending' => 'Ожидает оплаты',
                                                    'succeeded' => 'Успешно оплачен',
                                                    'canceled' => 'Отменен',
                                                    default => $order->latestPayment->status
                                                } }}
                                            </span>
                                        </p>

                                        {{-- Кнопка "Перейти к оплате" --}}
                                        @if($order->latestPayment->status === 'pending' && $order->latestPayment->confirmation_url)
                                            <a href="{{ $order->latestPayment->confirmation_url }}"
                                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                                                Перейти к оплате
                                            </a>
                                        @endif

                                        {{-- Кнопка "Сформировать новую ссылку", если платеж отменен --}}
                                        @if($order->latestPayment->status === 'canceled')
                                            <form method="POST" action="{{ route('orders.pay', $order) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-indigo-600 text-indigo-600 text-sm font-medium rounded-md hover:bg-indigo-50 transition">
                                                    Сформировать новую ссылку
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Статус чека --}}
                                        @if($order->latestPayment->receipts && $order->latestPayment->receipts->isNotEmpty())
                                            <p class="text-xs text-gray-500 mt-3">
                                                Чек: {{ $order->latestPayment->receipts->first()->status }}
                                            </p>
                                        @endif
                                    @else
                                        {{-- Если платеж не был создан (ошибка API) --}}
                                        <p class="text-sm text-red-600 mb-3">Ссылка на оплату не была сформирована.</p>
                                        <form method="POST" action="{{ route('orders.pay', $order) }}">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                                                Оплатить заказ
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif

                            {{-- НИЖНЯЯ ПАНЕЛЬ ДЕЙСТВИЙ --}}
                            <div class="flex flex-wrap items-center justify-between mt-6 pt-4 border-t border-gray-100 gap-4">

                                <div>
                                    <a href="{{ route('orders.payments', $order) }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-900 hover:underline">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        История платежей ({{ $order->payments->count() }})
                                    </a>
                                </div>

                                {{-- Кнопка отмены (только для наличных и ожидающих) --}}
                                <div>
                                    @if($order->status === \App\Models\Order::STATUS_PENDING && $order->payment_method === \App\Models\Order::PAYMENT_METHOD_CASH)
                                        <form method="POST" action="{{ route('orders.status.update', $order) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="canceled">
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                                Отменить заказ
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
