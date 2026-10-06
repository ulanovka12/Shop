<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Мои заказы
        </h2>
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
                            'canceled' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp

                    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                        {{-- Шапка --}}
                        <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap justify-between items-center gap-2">
                            <div>
                                <div class="font-semibold text-gray-800">Заказ #{{ $order->id }}</div>
                                <div class="text-sm text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                {{ $order->status_label }}
                            </span>
                        </div>

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

                            {{-- Состав --}}
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

                            {{-- Действие --}}
                            @if($order->status === \App\Models\Order::STATUS_PENDING)
                                <div class="flex justify-end">
                                    <form method="POST" action="{{ route('orders.status.update', $order) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="canceled">
                                        <button type="submit"
                                                class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                            Отменить заказ
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
