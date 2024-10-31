<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id',
            'name',
            'icon'
        ]);

        $result['icon'] = ($result['icon'])? asset('assets/media/country/'.$result['icon'])  : null;
        $result['list_product'] = new ProductCollection($this->allCategory);
        
        return $result;
    }
}