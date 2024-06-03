<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'regular_price' => $this->regular_price,
            'sale_price' => $this->sale_price,
            'on_sale' => $this->on_sale,
            'discount_percentage' => $this->discount_percentage,
            'is_favorite_for_current_user' => $this->is_favorite_for_current_user,
            'brand' => new ProductBrandResource($this->brand),
        ];
    }
}
