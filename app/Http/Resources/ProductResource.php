<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'brand_id' => $this->brand_id,
            'category_id' => $this->category_id,
            'primary_image' => url(env('PRODUCT_IMAGE_UPLOAD_PATH') . $this->primary_image),
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'delivery_amount' => $this->delivery_amount,
            'images' => ProductImageResource::collection($this->whenLoaded('images'))
        ];
    }
}
