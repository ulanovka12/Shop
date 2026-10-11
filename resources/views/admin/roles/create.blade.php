<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900">Создание роли</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @include('admin.roles._form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
