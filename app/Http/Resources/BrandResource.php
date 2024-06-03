<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'name' => $this->name,
            'address' => $this->address,
            'telephone' => $this->telephone,
            'phone' => $this->phone,
            'description' => $this->description,
            'categories' => CategoryResource::collection($this->categories),
            'products' => ProductResource::collection($this->products),
        ];
    }
}
