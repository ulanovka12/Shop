<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-100 rounded-lg">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Профиль') }}
                </h2>
                <p class="text-sm text-gray-500">Информация о вашей учетной записи</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-linear-to-br from-gray-50 to-indigo-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">

                {{-- Шапка с аватаром --}}
                <div class="relative h-32 bg-linear-to-r from-indigo-500 via-purple-500 to-pink-500">
                    <div class="absolute -bottom-12 left-8">
                        <div class="w-24 h-24 rounded-2xl bg-white p-1 shadow-xl">
                            <div class="w-full h-full rounded-xl bg-linear-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                <span class="text-3xl font-bold text-white">
                                    {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Информация --}}
                <div class="pt-16 pb-6 px-8">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Участник системы</p>
                </div>

                {{-- Данные --}}
                <div class="px-8 pb-8 space-y-4">

                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Имя</p>
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Email</p>
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $user->email }}</p>
                        </div>
                    </div>

                </div>

                {{-- Действия --}}
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row gap-3">

                    <a href="{{ route('profile.edit') }}"
                       class="inline-flex items-center justify-center gap-2 flex-1 px-5 py-2.5 bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold text-sm rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Редактировать профиль
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white hover:bg-red-50 text-red-600 border border-red-200 hover:border-red-300 font-semibold text-sm rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Выйти
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
