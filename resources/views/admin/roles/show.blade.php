@extends('layouts.admin')

@section('title', $product->name)

@section('content')
    @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}"
             alt="{{ $product->name }}"
             class="rounded-lg max-w-md">
    @endif
    <h1>{{ $product->name }}</h1>


    <div class="card">
        <div class="card-body">
            @if($product->image)
                <img src="{{ Storage::disk('public')->url($product->image) }}"
                     width="300" class="mb-3" alt="">
            @endif

            <p><strong>Цена:</strong> {{ number_format($product->price, 2) }}</p>
            <p><strong>Остаток:</strong> {{ $product->stock }}</p>
            <p><strong>SKU:</strong> {{ $product->sku }}</p>
            <p><strong>Статус:</strong> {{ $product->status }}</p>
        </div>
    </div>

    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning mt-3">Редактировать</a>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">Назад</a>
@endsection
