<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Knuckles\Scribe\Attributes\UrlParam;

#[Group("Product")]
#[Authenticated]
class ProductController extends Controller
{
    #[ResponseFromApiResource(
        name: ProductCollection::class,
        model: Product::class,
        description: 'Get all products'
    )]
    #[QueryParam(
        'search',
        description: 'the text that you want to search for',
        required: false,
        example: 'test'
    )]
    public function index(Request $request): ProductCollection
    {
        $products = Product::query()
            ->when($request->search, fn ($query) => $query->whereAny([
                'name',
                'description',
            ], 'LIKE', "%{$request->search}%"))
            ->get();
        return new ProductCollection($products);
    }

    #[ResponseFromApiResource(
        name: ProductResource::class,
        model: Product::class,
        description: 'Get single product'
    )]
    public function show(Request $request, Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    #[ResponseFromApiResource(
        name: ProductCollection::class,
        model: Product::class,
        description: 'Get all favorite products for the current logged in user'
    )]
    public function getFavoritesForCurrentUser()
    {
        $products = auth()->user()->favorites;

        return new ProductCollection($products);
    }

    #[Response(
        status: 204,
        description: 'Mark a product as favorite product for logged in user'
    )]
    public function favorite(Product $product)
    {
        $product->favorites()->attach(auth()->id());

        return response()->noContent();
    }

    #[Response(
        status: 204,
        description: 'Remove a product from favorite products for logged in user'
    )]
    public function unfavorite(Product $product)
    {
        $product->favorites()->detach(auth()->id());

        return response()->noContent();
    }
}
