<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900">Роли</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Роли пользователей</h1>
                    <p class="mt-1 text-sm text-gray-500">Список ролей и их системных идентификаторов.</p>
                </div>

                <a href="{{ route('admin.roles.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl
                          bg-linear-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold
                          hover:from-indigo-700 hover:to-purple-700
                          shadow-sm hover:shadow-lg transition-all">
                    + Добавить роль
                </a>
            </div>

            @if(session('success'))
                <div class="p-4 rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-800 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if($roles->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Ролей пока нет</h3>
                    <p class="mt-1 text-sm text-gray-500">Создайте первую роль.</p>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                        <tr class="bg-gray-50 text-left text-xs font-semibold uppercase text-gray-500">
                            <th class="px-5 py-3.5 w-16">ID</th>
                            <th class="px-5 py-3.5">Название</th>
                            <th class="px-5 py-3.5">Slug</th>
                            <th class="px-5 py-3.5 w-32 text-right">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($roles as $role)
                            <tr class="hover:bg-indigo-50/40">
                                <td class="px-5 py-4">{{ $role->id }}</td>
                                <td class="px-5 py-4 font-medium text-gray-900">{{ $role->name }}</td>
                                <td class="px-5 py-4">
                                    <code class="px-2 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-mono">
                                        {{ $role->slug }}
                                    </code>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.roles.edit', $role) }}"
                                           class="text-indigo-600 hover:underline text-xs font-medium">
                                            Ред.
                                        </a>
                                        <form action="{{ route('admin.roles.destroy', $role) }}"
                                              method="POST"
                                              onsubmit="return confirm('Удалить роль «{{ $role->name }}»?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline text-xs font-medium">
                                                Удал.
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="px-5 py-3 bg-gray-50 border-t text-xs text-gray-500">
                        Всего ролей: <span class="font-semibold text-gray-700">{{ $roles->count() }}</span>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
