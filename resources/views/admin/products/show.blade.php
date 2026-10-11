<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900">{{ $product->name }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="rounded-lg mb-4 max-w-sm">
                @endif

                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <dt class="text-gray-500">Цена</dt>
                    <dd class="font-medium">{{ number_format($product->price, 2) }} ₽</dd>

                    <dt class="text-gray-500">Остаток</dt>
                    <dd class="font-medium">{{ $product->stock }}</dd>

                    <dt class="text-gray-500">SKU</dt>
                    <dd class="font-medium">{{ $product->sku }}</dd>

                    <dt class="text-gray-500">Активен</dt>
                    <dd class="font-medium">{{ $product->is_active ? 'Да' : 'Нет' }}</dd>

                    <dt class="text-gray-500">Описание</dt>
                    <dd class="font-medium col-span-2">{{ $product->description ?? '—' }}</dd>
                </dl>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('admin.products.edit', $product) }}"
                       class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                        Редактировать
                    </a>
                    <a href="{{ route('admin.products.index') }}"
                       class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-gray-200">
                        Назад
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
