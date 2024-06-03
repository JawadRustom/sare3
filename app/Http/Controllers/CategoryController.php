<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group("Category")]
class CategoryController extends Controller
{
    #[ResponseFromApiResource(
        name: CategoryCollection::class,
        model: Category::class,
        description: 'Get all categories'
    )]
    public function index(Request $request): CategoryCollection
    {
        $categories = Category::all();

        return new CategoryCollection($categories);
    }
}
