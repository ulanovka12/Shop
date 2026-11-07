<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('История платежей по заказу #') . $order->id }}
            </h2>
            <a href="{{ route('orders.index') }}" class="text-sm text-indigo-600 hover:underline">
                &larr; Вернуться к заказам
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Краткая информация о заказе -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <span class="text-xs text-gray-500 uppercase">Сумма заказа</span>
                            <div class="font-bold text-lg">{{ number_format((float)$order->total, 0, ',', ' ') }} ₽</div>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase">Статус заказа</span>
                            <div class="font-semibold">{{ $order->status_label }}</div>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase">Способ оплаты</span>
                            <div>{{ $order->payment_method_label }}</div>
                        </div>
                    </div>
                </div>

                <!-- Таблица попыток оплаты -->
                <h3 class="font-semibold text-lg mb-4">Попытки оплаты</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr class="border-b bg-gray-50 text-sm">
                            <th class="p-3">Дата</th>
                            <th class="p-3">Сумма</th>
                            <th class="p-3">Статус</th>
                            <th class="p-3">ID транзакции</th>
                            <th class="p-3">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($payments as $payment)
                            <tr class="border-b hover:bg-gray-50 text-sm">
                                <td class="p-3">{{ $payment->created_at->format('d.m.Y H:i') }}</td>
                                <td class="p-3">{{ number_format((float)$payment->amount, 0, ',', ' ') }} ₽</td>
                                <td class="p-3">
                                    @php
                                        $color = match($payment->status) {
                                            'succeeded' => 'bg-green-100 text-green-800',
                                            'canceled' => 'bg-red-100 text-red-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs {{ $color }}">
                                            {{ $payment->status }}
                                        </span>
                                </td>
                                <td class="p-3 font-mono text-xs text-gray-500">
                                    {{ $payment->external_payment_id ?? '—' }}
                                </td>
                                <td class="p-3">
                                    @if($payment->status === 'pending' && $payment->confirmation_url)
                                        <a href="{{ $payment->confirmation_url }}" class="text-indigo-600 hover:underline">
                                            Перейти к оплате
                                        </a>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-gray-500">
                                    Попыток оплаты пока не было.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
