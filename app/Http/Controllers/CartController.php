<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\CartItemData;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Product;
use App\Services\SessionCartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
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
    public function store(AddToCartRequest $request, Product $product): JsonResponse|RedirectResponse
    {
        $this->sessionCartService->add(
            CartItemData::fromRequest($request, $product)
        );

        return $this->respond($request);
    }

    public function update(UpdateCartRequest $request, Product $product): JsonResponse|RedirectResponse
    {
        $this->sessionCartService->setQuantity(
            CartItemData::fromRequest($request, $product)
        );

        return $this->respond($request);
    }

    public function destroy(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $this->sessionCartService->remove($product);

        return $this->respond($request);
    }

    public function clear(Request $request): JsonResponse|RedirectResponse
    {
        $this->sessionCartService->clear();

        return $this->respond($request);
    }

    private function respond(Request $request): JsonResponse|RedirectResponse
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
