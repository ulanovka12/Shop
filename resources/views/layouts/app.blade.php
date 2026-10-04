<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation')

    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main class="container">
        {{ $slot }}
    </main>
</div>

<div id="toast" style="position:fixed;bottom:24px;right:24px;z-index:9999;display:none;">
    <div style="padding:12px 16px;background:#111;color:#fff;font-size:14px;border-radius:12px;box-shadow:0 10px 15px -3px rgba(0,0,0,.1);"></div>
</div>

<script>
    function showToast(message, type = 'success') {
        const box = document.getElementById('toast');
        if (!box) return;
        const inner = box.querySelector('div');
        inner.textContent = message;
        inner.style.background = type === 'error' ? '#dc2626' : '#111';
        box.style.display = 'block';
        clearTimeout(box._timer);
        box._timer = setTimeout(() => box.style.display = 'none', 2500);
    }

    async function submitCartForm(form, submitter = null) {
        const formData = new FormData(form);

        if (submitter && submitter.name) {
            formData.append(submitter.name, submitter.value);
        }

        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        });

        if (!response.ok) {
            console.warn('Cart request failed', response.status, await response.text());
            showToast('Не удалось выполнить действие', 'error');
            return;
        }

        const data = await response.json();

        if (typeof data.cartCount !== 'undefined') {
            document.querySelectorAll('[data-cart-count]').forEach(el => {
                el.textContent = data.cartCount;
            });
        }

        const cartContent = document.getElementById('cart-content');
        if (cartContent && typeof data.html === 'string') {
            cartContent.innerHTML = data.html;
        }

        showToast(form.dataset.toast || 'Готово');
    }

    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (!(form instanceof HTMLFormElement)) return;
        if (!form.hasAttribute('data-ajax-cart')) return;
        e.preventDefault();
        submitCartForm(form, e.submitter);
    });

    document.addEventListener('change', function (e) {
        const input = e.target;
        if (!(input instanceof HTMLInputElement)) return;
        const form = input.closest('form[data-ajax-cart]');
        if (!form) return;
        if (form.getAttribute('data-cart-action') !== 'set') return;
        submitCartForm(form);
    });
</script>
</body>
</html>

