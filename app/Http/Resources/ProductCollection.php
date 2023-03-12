<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($product) {
            return [
                "id" => $product->id,
                "title" => $product->title,
                "amount" => $product->amount,
                "price" => $product->price,
                "discount" => $product->discount,
                "image" => $product->image,
                "description" => $product->description,
            ];
        });
    }
}
