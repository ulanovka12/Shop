@php($addresses = auth()->user()->addresses)
@php($default = $addresses->firstWhere('is_default', true) ?? $addresses->first())

@if ($addresses->isEmpty())
    <p class="text-sm text-amber-600">
        У вас нет сохранённых адресов.
        <a href="{{ route('profile.edit') }}" class="underline">Добавить адрес</a>
    </p>
@else
    <select name="address_id" class="mt-1 block w-full rounded-md border-gray-300">
        @foreach ($addresses as $address)
            <option value="{{ $address->id }}" @selected($address->id === $default?->id)>
                {{ $address->full_address }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('address_id')" class="mt-2" />
@endif
