<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900">Роли</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Заголовок + действие --}}
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Роли пользователей</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Список ролей и их системных идентификаторов.
                    </p>
                </div>

                <a href="{{ route('admin.roles.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl
                          bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold
                          hover:from-indigo-700 hover:to-purple-700
                          shadow-sm hover:shadow-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Добавить роль
                </a>
            </div>

            @if($roles->isEmpty())
                {{-- Пустое состояние --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-indigo-50 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Ролей пока нет</h3>
                    <p class="mt-1 text-sm text-gray-500">Создайте первую роль, чтобы начать разграничение доступа.</p>
                    <a href="{{ route('admin.roles.create') }}"
                       class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                              bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Создать роль
                    </a>
                </div>
            @else
                {{-- Таблица --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                        <tr class="bg-gray-50/70 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            <th class="px-5 py-3.5 w-16">ID</th>
                            <th class="px-5 py-3.5">Название</th>
                            <th class="px-5 py-3.5">Slug</th>
                            <th class="px-5 py-3.5 w-32 text-right">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($roles as $role)
                            <tr class="group hover:bg-indigo-50/40 transition-colors">

                                {{-- ID --}}
                                <td class="px-5 py-4">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                                     bg-gray-100 text-gray-600 text-xs font-semibold
                                                     group-hover:bg-indigo-100 group-hover:text-indigo-700 transition-colors">
                                            {{ $role->id }}
                                        </span>
                                </td>

                                {{-- Название --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500
                                                         flex items-center justify-center text-white text-xs font-bold">
                                                {{ mb_substr($role->name, 0, 1) }}
                                            </span>
                                        <span class="font-medium text-gray-900">{{ $role->name }}</span>
                                    </div>
                                </td>

                                {{-- Slug --}}
                                <td class="px-5 py-4">
                                    <code class="inline-flex px-2.5 py-1 rounded-md
                                                     bg-slate-100 text-slate-700 text-xs font-mono
                                                     group-hover:bg-slate-200 transition-colors">
                                        {{ $role->slug }}
                                    </code>
                                </td>

                                {{-- Действия --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.roles.edit', $role) }}"
                                           title="Редактировать"
                                           class="p-2 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                              onsubmit="return confirm('Удалить роль «{{ $role->name }}»?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    title="Удалить"
                                                    class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{-- Футер таблицы --}}
                    <div class="px-5 py-3 bg-gray-50/60 border-t border-gray-100 text-xs text-gray-500 flex items-center justify-between">
                        <span>Всего ролей: <span class="font-semibold text-gray-700">{{ $roles->count() }}</span></span>
                        @if(method_exists($roles, 'links'))
                            <div>{{ $roles->links() }}</div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
