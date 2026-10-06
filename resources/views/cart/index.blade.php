<x-app-layout>
    <x-slot name="header">Корзина</x-slot>

    @if($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-red-50 text-red-700 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 rounded-xl bg-red-50 text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-green-50 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div id="cart-content">
        @include('cart._content', [
            'items'         => $items,
            'totalQuantity' => $totalQuantity,
            'totalPrice'    => $totalPrice,
        ])
    </div>


</x-app-layout>
