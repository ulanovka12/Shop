<x-app-layout>
    <x-slot name="header">Корзина</x-slot>

    <div id="cart-content">
        @include('cart._content', [
            'items'         => $items,
            'totalQuantity' => $totalQuantity,
            'totalPrice'    => $totalPrice,
        ])
    </div>
</x-app-layout>
