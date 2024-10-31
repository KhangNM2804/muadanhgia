<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataSelledResource extends JsonResource
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
            'uid',
            'full_info',
            'link_backup',
        ]);

        $result['link_backup'] = route('download_backup', ['buy_id' => $this->buy_id, 'uid' => $this->uid]);

        return $result;
    }
}
