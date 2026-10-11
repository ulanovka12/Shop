<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900">Товары</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Список товаров</h1>
                    <p class="mt-1 text-sm text-gray-500">Управление каталогом товаров.</p>
                </div>

                <a href="{{ route('admin.products.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl
                          bg-linear-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold
                          hover:from-indigo-700 hover:to-purple-700
                          shadow-sm hover:shadow-lg transition-all">
                    + Добавить товар
                </a>
            </div>

            @if(session('success'))
                <div class="p-4 rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-800 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if($products->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Товаров пока нет</h3>
                    <p class="mt-1 text-sm text-gray-500">Создайте первый товар, чтобы начать работу.</p>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                        <tr class="bg-gray-50/70 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            <th class="px-5 py-3.5 w-16">ID</th>
                            <th class="px-5 py-3.5 w-20">Фото</th>
                            <th class="px-5 py-3.5">Название</th>
                            <th class="px-5 py-3.5">SKU</th>
                            <th class="px-5 py-3.5">Цена</th>
                            <th class="px-5 py-3.5">Остаток</th>
                            <th class="px-5 py-3.5">Активен</th>
                            <th class="px-5 py-3.5 w-32 text-right">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($products as $product)
                            <tr class="group hover:bg-indigo-50/40 transition-colors">
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                                 bg-gray-100 text-gray-600 text-xs font-semibold">
                                        {{ $product->id }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $product->name }}"
                                             width="40" height="40"
                                             class="rounded-lg object-cover">
                                    @else
                                        <span class="text-gray-400 text-xs">нет</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-5 py-4">
                                    <code class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-mono">
                                        {{ $product->sku }}
                                    </code>
                                </td>
                                <td class="px-5 py-4">{{ number_format($product->price, 2) }} ₽</td>
                                <td class="px-5 py-4">{{ $product->stock }}</td>
                                <td class="px-5 py-4">
                                    @if($product->is_active)
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                            Активен
                                        </span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                            Скрыт
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                           class="px-2 py-1 rounded-lg text-xs font-medium text-indigo-600 hover:bg-indigo-50">
                                            Ред.
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product) }}"
                                              method="POST"
                                              onsubmit="return confirm('Удалить товар «{{ $product->name }}»?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-2 py-1 rounded-lg text-xs font-medium text-red-600 hover:bg-red-50">
                                                Удал.
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="px-5 py-3 bg-gray-50/60 border-t border-gray-100 text-xs text-gray-500 flex items-center justify-between">
                        <span>Всего: <span class="font-semibold text-gray-700">{{ $products->total() }}</span></span>
                        <div>{{ $products->links() }}</div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
