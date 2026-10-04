<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\SessionCartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController
{
    public function __construct(
        private SessionCartService $sessionCartService,
    ) {
    }

    public function index(): Factory|View
    {
        return view('cart.index', [
            'items'         => $this->sessionCartService->getItems(),
            'totalQuantity' => $this->sessionCartService->getTotalQuantity(),
            'totalPrice'    => $this->sessionCartService->getTotalPrice(),
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $this->sessionCartService->add($product, (int) ($data['quantity'] ?? 1));

        return $this->respond($request);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $this->sessionCartService->setQuantity($product, (int) $data['quantity']);

        return $this->respond($request);
    }

    public function destroy(Request $request, Product $product)
    {
        $this->sessionCartService->remove($product);

        return $this->respond($request);
    }

    public function clear(Request $request)
    {
        $this->sessionCartService->clear();

        return $this->respond($request);
    }

    private function respond(Request $request)
    {
        $cartCount = $this->sessionCartService->getTotalQuantity();

        if ($request->expectsJson()) {
            return response()->json([
                'cartCount' => $cartCount,
                'html'      => view('cart._content', [
                    'items'         => $this->sessionCartService->getItems(),
                    'totalQuantity' => $cartCount,
                    'totalPrice'    => $this->sessionCartService->getTotalPrice(),
                ])->render(),
            ]);
        }

        return redirect()
            ->back()
            ->with('cartCount', $cartCount);
    }
}
