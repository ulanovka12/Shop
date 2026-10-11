

{{-- Название --}}
<div class="mb-4">
    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Название</label>
    <input type="text"
           name="name"
           id="name"
           class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                  @error('name') border-red-500 @enderror"
           value="{{ old('name', $product->name ?? '') }}">
    @error('name')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Цена --}}
<div class="mb-4">
    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Цена</label>
    <input type="number"
           step="0.01"
           min="0"
           name="price"
           id="price"
           class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                  @error('price') border-red-500 @enderror"
           value="{{ old('price', $product->price ?? '') }}">
    @error('price')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Остаток --}}
<div class="mb-4">
    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Остаток</label>
    <input type="number"
           min="0"
           name="stock"
           id="stock"
           class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                  @error('stock') border-red-500 @enderror"
           value="{{ old('stock', $product->stock ?? '') }}">
    @error('stock')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- SKU --}}
<div class="mb-4">
    <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU (артикул)</label>
    <input type="text"
           name="sku"
           id="sku"
           class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                  @error('sku') border-red-500 @enderror"
           value="{{ old('sku', $product->sku ?? '') }}">
    @error('sku')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Описание --}}
<div class="mb-4">
    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
    <textarea name="description"
              id="description"
              rows="4"
              class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                     @error('description') border-red-500 @enderror">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Активен (boolean is_active) --}}
<div class="mb-4">
    {{-- Скрытое поле нужно: если чекбокс не отмечен, браузер не отправит ничего --}}
    <input type="hidden" name="is_active" value="0">

    <label class="inline-flex items-center gap-2">
        <input type="checkbox"
               name="is_active"
               value="1"
               @checked(old('is_active', $product->is_active ?? true))
               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        <span class="text-sm font-medium text-gray-700">Активен</span>
    </label>
    @error('is_active')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Изображение --}}
<div class="mb-6">
    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Изображение</label>
    <input type="file"
           name="image"
           id="image"
           accept="image/*"
           class="w-full rounded-xl border border-gray-300 p-2
                  @error('image') border-red-500 @enderror">
    @error('image')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror

    @isset($product)
        @if($product->image)
            <div class="mt-3">
                <p class="text-xs text-gray-500 mb-2">Текущее изображение:</p>
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="rounded-lg border border-gray-200"
                     width="150">
            </div>
        @endif
    @endisset
</div>

{{-- Кнопки --}}
<div class="flex items-center gap-3">
    <button type="submit"
            class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold
                   hover:bg-indigo-700 transition-colors">
        Сохранить
    </button>
    <a href="{{ route('admin.products.index') }}"
       class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-semibold
              hover:bg-gray-200 transition-colors">
        Отмена
    </a>
</div>
