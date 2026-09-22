<section class="space-y-6">
    <header class="flex items-start gap-3">
        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-red-700">
                {{ __('Удаление аккаунта') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('После удаления аккаунта все его ресурсы и данные будут безвозвратно удалены. Перед удалением сохраните всю нужную информацию.') }}
            </p>
        </div>
    </header>

    {{-- Кнопка открытия модалки --}}
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-red-50 text-red-600
               border border-red-200 hover:border-red-300
               font-semibold text-sm rounded-lg shadow-sm hover:shadow-md
               transition-all duration-200
               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        {{ __('Удалить аккаунт') }}
    </button>

    {{-- Модальное окно подтверждения --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8">
            @csrf
            @method('delete')

            {{-- Заголовок с иконкой --}}
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-lg font-bold text-gray-900">
                        {{ __('Удалить аккаунт?') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Это действие необратимо. Все данные будут удалены навсегда. Для подтверждения введите пароль.') }}
                    </p>
                </div>
            </div>

            {{-- Предупреждение --}}
            <div class="mt-6 p-4 rounded-xl bg-red-50 border border-red-200">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-red-800">
                        <p class="font-semibold">Будут удалены:</p>
                        <ul class="mt-1 space-y-0.5 list-disc list-inside text-red-700">
                            <li>Профиль и персональные данные</li>
                            <li>Все созданные записи и файлы</li>
                            <li>История активности</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Поле ввода пароля --}}
            <div class="mt-6">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ __('Введите пароль для подтверждения') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="{{ __('Пароль') }}"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg
                               focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-200 focus:outline-none
                               transition-all duration-200
                               @if($errors->userDeletion->has('password')) border-red-300 bg-red-50 @endif"
                    />
                </div>
                @if($errors->userDeletion->has('password'))
                    <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $errors->userDeletion->first('password') }}
                    </p>
                @endif
            </div>

            {{-- Кнопки --}}
            <div class="mt-8 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white hover:bg-gray-50
                           text-gray-700 border border-gray-300 hover:border-gray-400
                           font-semibold text-sm rounded-lg shadow-sm hover:shadow-md
                           transition-all duration-200
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400"
                >
                    {{ __('Отмена') }}
                </button>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5
                           bg-gradient-to-r from-red-600 to-rose-600
                           hover:from-red-700 hover:to-rose-700
                           text-white font-semibold text-sm rounded-lg shadow-md hover:shadow-lg
                           transform hover:-translate-y-0.5 transition-all duration-200
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    {{ __('Удалить навсегда') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
