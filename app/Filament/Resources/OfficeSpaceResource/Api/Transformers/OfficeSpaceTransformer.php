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
        $data = [
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'thumbnail'     => $this->thumbnail,
            'about'         => $this->about,
            'price'         => $this->price,
            'duration'      => $this->duration,
            'address'       => $this->address
        ];

        if ($this->photos && $this->photos->isNotEmpty()) {
            foreach ($this->photos as $key => $value) {
                $data['photos'][] = [
                    'id'        => $value->id,
                    'photo'     => $value->photo
                ];
            }
        } else {
            $data['photos'] = null;
        }

        if ($this->benefits && $this->benefits->isNotEmpty()) {
            foreach ($this->benefits as $key => $value) {
                $data['benefits'][] = [
                    'id'   => $value->id,
                    'name' => $value->name,
                    'icon' => $value->icon,
                ];
            }
        } else {
            $data['benefits'] = null;
        }

        if ($this->city) {
            $data['city'] = [
                'id'    => $this->city->id,
                'name'  => $this->city->name,
                'slug'  => $this->city->slug,
                'photo' => $this->city->photo,
            ];
        } else {
            $data['city'] = null;
        }

        // return $data;
        return [
            'data' => $data,
            'status' => 'OK'
        ];
    }
}
