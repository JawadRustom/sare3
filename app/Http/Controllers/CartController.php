<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Http\Resources\CartCollection;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group("Cart")]
#[Authenticated]
class CartController extends Controller
{
    #[ResponseFromApiResource(
        name: CartCollection::class,
        model: Cart::class,
        description: 'Get all cart items of the logged in user'
    )]
    public function index(): CartCollection
    {
        $carts = auth()->user()->carts;

        return new CartCollection($carts);
    }

    #[ResponseFromApiResource(
        name: CartResource::class,
        model: Cart::class,
        description: 'create new cart item for the logged in user'
    )]
    public function store(CartStoreRequest $request): CartResource
    {
        $cart = auth()->user()->carts()->create($request->validated());
        return new CartResource($cart);
    }

    #[ResponseFromApiResource(
        name: CartResource::class,
        model: Cart::class,
        description: 'update a cart item for the logged in user'
    )]
    public function update(CartUpdateRequest $request, Cart $cart): CartResource
    {
        $cart->update($request->validated());

        return new CartResource($cart);
    }

    #[Response(
        status: 204,
    )]
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->noContent();
    }
}
