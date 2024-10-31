<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailOrderResource extends JsonResource
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
            'quantity',
            'price',
            'total_price',
            'type',
            'created_at',
            'data'
        ]);
        
        $result['type'] = $this->resource->gettype->name;
        $result['data'] = new DataSelledCollection($this->resource->getSelled);
        return $result;
    }
}
