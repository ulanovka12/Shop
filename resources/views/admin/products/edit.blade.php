<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900">
            Редактирование: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                @if($errors->any())
                    <div class="mb-4 p-4 rounded-xl border border-red-200 bg-red-50 text-red-800 text-sm">
                        <p class="font-semibold mb-2">Исправьте ошибки:</p>
                        <ul class="list-disc ml-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.update', $product) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.products._form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
