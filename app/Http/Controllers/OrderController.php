<?php

namespace App\Http\Controllers;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group("Order")]
#[Authenticated]
class OrderController extends Controller
{
    #[ResponseFromApiResource(
        name: OrderCollection::class,
        model: Order::class,
        description: 'Get all orders of the logged in user'
    )]
    public function index(Request $request): OrderCollection
    {
        $orders = auth()->user()->orders;

        return new OrderCollection($orders);
    }

    #[ResponseFromApiResource(
        name: OrderResource::class,
        model: Order::class,
        description: 'create a new order for the logged in user'
    )]
    public function store(OrderStoreRequest $request): OrderResource
    {
        /**
         * @var User
         */
        $user = auth()->user();
        $order = $user->orders()->create();

        foreach ($user->carts as $cartItem) {
            $order->orderItems()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
            ]);
        }

        $user->carts()->delete();

        return new OrderResource($order);
    }
}
