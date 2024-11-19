<?php
namespace App\Filament\Resources\OfficeSpaceResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OfficeSpaceTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
