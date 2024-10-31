<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = $this->resource->only([
            'id_product',
            'name',
            'desc',
            'price',
            'quantity'
        ]);
        
        $result['id_product'] = $this->id;
        $result['quantity'] = $this->resource->sell()->count();
        return $result;
    }
}