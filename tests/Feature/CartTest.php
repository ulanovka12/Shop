<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_add_product_to_cart(): void
    {
        // Arrange
        $product = Product::factory()->create();

        // Act
        $response = $this->post("/cart/items/{$product->id}", [
            'quantity' => 1,
        ]);

        // Assert
        // Проверяем, что гостя перенаправило на страницу входа
        $response->assertRedirect('/login');
    }

    public function test_user_can_add_product_to_cart(): void
    {
        // Arrange
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 1500]);

        // Act
        $response = $this->actingAs($user)
            ->post("/cart/items/{$product->id}", [
                'quantity' => 2,
            ]);

        // Assert
        // 1. Проверяем, что запрос прошел успешно (редирект назад или JSON)
        $response->assertStatus(302);

        // 2. Проверяем, что данные появились в сессии
        // ВАЖНО: Вам нужно заглянуть в ваш SessionCartService, чтобы узнать,
        // под каким ключом он сохраняет корзину (например, 'cart' или 'shopping_cart')

        $this->assertTrue(session()->has('cart'));

        // корзина хранится как массив, где ключ - это ID товара:
        $cart = session()->get('cart');

//        dump($cart);

        // Assert
        $response->assertStatus(302);

        $this->assertTrue(session()->has('cart'));

        $cart = session()->get('cart');

        // Проверяем, что в массиве 'items' есть ключ с ID нашего товара
        $this->assertArrayHasKey($product->id, $cart['items']);

        // Проверяем, что количество этого товара равно 2
        $this->assertEquals(2, $cart['items'][$product->id]);
    }
}
