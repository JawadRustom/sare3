<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CartController
 */
final class CartControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $carts = Cart::factory()->count(3)->create();

        $response = $this->get(route('carts.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CartController::class,
            'store',
            \App\Http\Requests\CartStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $quantity = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->post(route('carts.store'), [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);

        $carts = Cart::query()
            ->where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('quantity', $quantity)
            ->get();
        $this->assertCount(1, $carts);
        $cart = $carts->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CartController::class,
            'update',
            \App\Http\Requests\CartUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $cart = Cart::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $quantity = $this->faker->randomFloat(/** double_attributes **/);

        $response = $this->put(route('carts.update', $cart), [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);

        $cart->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user->id, $cart->user_id);
        $this->assertEquals($product->id, $cart->product_id);
        $this->assertEquals($quantity, $cart->quantity);
    }
}
