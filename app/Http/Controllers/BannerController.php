<?php

namespace App\Http\Controllers;

use App\Http\Resources\BannerCollection;
use App\Models\Banner;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group("Banner")]
class BannerController extends Controller
{
    #[ResponseFromApiResource(
        name: BannerCollection::class,
        model: Banner::class,
        description: 'Get all banners'
    )]
    public function index(Request $request): BannerCollection
    {
        $banners = Banner::all();

        return new BannerCollection($banners);
    }
}
