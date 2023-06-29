<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_see_cart_page(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/cart');

        $response->assertStatus(200);
    }

    public function test_can_add_product_to_cart(): void
    {
        $this->withoutExceptionHandling();

        $this->seed([DatabaseSeeder::class]);
        $product = Product::query()->inRandomOrder()->firstOrFail();

        $response = $this->post('/cart/add', [
            'product_id' => $product->id,
        ]);

        $response->assertJson(['message' => 'Product added to cart']);
        $response->assertOk();

        $this->assertDatabaseHas('cart_product', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    public function test_can_update_product_quantity_in_cart(): void
    {
        $this->withoutExceptionHandling();

        $this->seed([DatabaseSeeder::class]);
        $product = Product::query()->inRandomOrder()->firstOrFail();

        $this->post('/cart/add', [
            'product_id' => $product->id,
        ]);

        $response = $this->patch('/cart/' . $product->id, [
            'quantity' => 2,
        ]);

        $response->assertOk();
        $response->assertJson(['message' => 'Cart updated']);
    }

    public function test_can_delete_product_from_cart(): void
    {
        $this->withoutExceptionHandling();

        $this->seed([DatabaseSeeder::class]);
        $product = Product::query()->inRandomOrder()->firstOrFail();

        $this->post('/cart/add', [
            'product_id' => $product->id,
        ]);
        $this->assertDatabaseCount('cart_product', 1);
        $this->assertDatabaseCount('carts', 1);

        $response = $this->delete("/cart/$product->id");

        $response->assertOk();
        $response->assertJson(['message' => 'Product removed from cart']);

        //I don't know why this test fails with the following error:
        //Failed asserting that table [cart_product] matches expected entries count of 0. Entries found: 1
        $this->assertDatabaseCount('cart_product', 0);
    }
}
