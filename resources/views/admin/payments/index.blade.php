<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Платежи YooKassa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr class="border-b bg-gray-50 text-sm">
                            <th class="p-3">ID Платежа (ЮKassa)</th>
                            <th class="p-3">Заказ</th>
                            <th class="p-3">Email клиента</th>
                            <th class="p-3">Сумма</th>
                            <th class="p-3">Статус</th>
                            <th class="p-3">Дата создания</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($payments as $payment)
                            <tr class="border-b hover:bg-gray-50 text-sm">
                                <td class="p-3 font-mono text-xs">{{ $payment->external_payment_id }}</td>
                                <td class="p-3">
                                    <a href="#" class="text-indigo-600 hover:underline">#{{ $payment->order_id }}</a>
                                </td>
                                <td class="p-3">{{ $payment->order->user->email ?? 'Гость' }}</td>
                                <td class="p-3 font-semibold">{{ number_format((float)$payment->amount, 0, ',', ' ') }} ₽</td>
                                <td class="p-3">
                                    @php
                                        $color = match($payment->status) {
                                            'succeeded' => 'bg-green-100 text-green-800',
                                            'canceled' => 'bg-red-100 text-red-800',
                                            default => 'bg-yellow-100 text-yellow-800',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs {{ $color }}">
                                        {{ $payment->status }}
                                    </span>
                                </td>
                                <td class="p-3 text-gray-500">{{ $payment->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-3 text-center text-gray-500">Платежей пока нет</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $payments->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
