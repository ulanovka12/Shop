<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Админка') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

{{-- Верхняя навигация --}}
<header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-16 flex items-center justify-between gap-4">

            {{-- Логотип --}}
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 shrink-0">
                    <span class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 7l9-4 9 4-9 4-9-4zm0 0v10l9 4 9-4V7"/>
                        </svg>
                    </span>
                <span class="font-bold text-lg tracking-tight">{{ config('app.name') }}</span>
                <span class="hidden sm:inline text-xs font-semibold text-indigo-600 bg-indigo-50 rounded-full px-2 py-0.5">
                        admin
                    </span>
            </a>

            {{-- Меню --}}
            <nav class="hidden md:flex items-center gap-1 text-sm">
                @php
                    $links = [
                        ['route' => 'admin.dashboard', 'label' => 'Дашборд'],
                        ['route' => 'admin.roles.index', 'label' => 'Роли'],
                        ['route' => 'products.index', 'label' => 'На сайт'],
                    ];
                @endphp

                @foreach($links as $link)
                    @php $active = request()->routeIs($link['route']) || request()->routeIs(str_replace('.index', '.*', $link['route'])); @endphp
                    <a href="{{ route($link['route']) }}"
                       class="px-3 py-2 rounded-lg font-medium transition-colors
                                  {{ $active
                                        ? 'text-indigo-700 bg-indigo-50'
                                        : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- Профиль + выход --}}
            <div class="flex items-center gap-2">

                {{-- Имя пользователя --}}
                <div class="hidden sm:flex items-center gap-2 pl-3 pr-2 py-1.5 rounded-full bg-slate-100">
                        <span class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-xs font-semibold">
                            {{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </span>
                    <span class="text-sm font-medium text-slate-700">
                            {{ auth()->user()->name ?? 'Админ' }}
                        </span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium
                                       text-red-600 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Выйти</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Мобильное меню --}}
        <nav class="md:hidden flex gap-1 pb-3 overflow-x-auto">
            @foreach($links as $link)
                @php $active = request()->routeIs($link['route']) || request()->routeIs(str_replace('.index', '.*', $link['route'])); @endphp
                <a href="{{ route($link['route']) }}"
                   class="whitespace-nowrap px-3 py-1.5 rounded-lg text-sm font-medium transition-colors
                              {{ $active
                                    ? 'text-indigo-700 bg-indigo-50'
                                    : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</header>

{{-- Контент --}}
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Flash-сообщения --}}
    @if(session('success'))
        <div class="mb-4 flex items-start gap-3 p-4 rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-800">
            <svg class="w-5 h-5 shrink-0 mt-0.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 flex items-start gap-3 p-4 rounded-2xl border border-red-200 bg-red-50 text-red-800">
            <svg class="w-5 h-5 shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01M4.93 19h14.14a2 2 0 001.74-2.99L13.74 4.99a2 2 0 00-3.48 0L3.19 16A2 2 0 004.93 19z"/>
            </svg>
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    @yield('content')
</main>

</body>
</html>
