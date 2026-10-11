<div class="space-y-4">
    @forelse ($user->addresses as $address)
        <div class="flex justify-between items-start p-4 border border-gray-100 rounded-xl">
            <div>
                <p class="font-medium text-gray-900">
                    {{ $address->full_address }}
                    @if ($address->is_default)
                        <span class="ml-2 text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded">
                            По умолчанию
                        </span>
                    @endif
                </p>
            </div>
            <div class="flex gap-3 shrink-0">
                @unless ($address->is_default)
                    <form method="POST" action="{{ route('addresses.default', $address) }}">
                        @csrf @method('PATCH')
                        <button class="text-sm text-indigo-600 hover:text-indigo-800">Основной</button>
                    </form>
                @endunless
                <form method="POST" action="{{ route('addresses.destroy', $address) }}"
                      onsubmit="return confirm('Удалить адрес?')">
                    @csrf @method('DELETE')
                    <button class="text-sm text-red-600 hover:text-red-800">Удалить</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-sm text-gray-500">Адресов пока нет. Добавьте первый ниже.</p>
    @endforelse

    <form method="POST" action="{{ route('addresses.store') }}"
          class="mt-6 grid gap-3 sm:grid-cols-2 pt-6 border-t border-gray-100">
        @csrf
        <x-text-input name="city"        placeholder="Город"      :value="old('city')" />
        <x-text-input name="street"      placeholder="Улица, дом" :value="old('street')" />
        <x-text-input name="postal_code" placeholder="Индекс"     :value="old('postal_code')" />
        <x-text-input name="phone"       placeholder="Телефон"    :value="old('phone')" />
        <x-input-error :messages="$errors->get('city')"   class="sm:col-span-2 -mt-2" />
        <x-input-error :messages="$errors->get('street')" class="sm:col-span-2 -mt-2" />

        <label class="flex items-center gap-2 sm:col-span-2">
            <input type="checkbox" name="is_default" value="1"
                   class="rounded border-gray-300 text-indigo-600" @checked(old('is_default'))>
            <span class="text-sm text-gray-600">Сделать адресом по умолчанию</span>
        </label>

        <x-primary-button class="sm:col-span-2 justify-center">Добавить адрес</x-primary-button>
    </form>
</div>
