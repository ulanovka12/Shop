@csrf

@isset($role)
    @method('PUT')
@endisset

<div class="mb-4">
    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Название</label>
    <input type="text"
           name="name"
           id="name"
           class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                  @error('name') border-red-500 @enderror"
           value="{{ old('name', $role->name ?? '') }}">
    @error('name')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mb-6">
    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
    <input type="text"
           name="slug"
           id="slug"
           class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                  @error('slug') border-red-500 @enderror"
           value="{{ old('slug', $role->slug ?? '') }}">
    @error('slug')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="flex items-center gap-3">
    <button type="submit"
            class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold
                   hover:bg-indigo-700 transition-colors">
        Сохранить
    </button>
    <a href="{{ route('admin.roles.index') }}"
       class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-semibold
              hover:bg-gray-200 transition-colors">
        Отмена
    </a>
</div>
