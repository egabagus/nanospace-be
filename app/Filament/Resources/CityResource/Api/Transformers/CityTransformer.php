<?php

namespace App\Filament\Resources\CityResource\Api\Transformers;

use App\Models\City;
use Illuminate\Http\Resources\Json\JsonResource;

class CityTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return $this->resource->toArray();
        $count = City::with('officeSpaces')->get();
        // dd($count);
        // return $count->map(function ($city) {
        //     return [
        //         'id' => $city->id,
        //         'name' => $city->name,
        //         'slug' => $city->slug,
        //         'photo' => $city->photo,
        //         'officeSpaces_count' => $city->office_spaces_count, // Akses langsung dari elemen koleksi
        //     ];
        // });

        foreach ($count as $city) {
            // dd($city);
            // return [
            return response()->json([
                'id' => $city->id,
                'officeSpaces_count' => $city->office_spaces_count
            ]);
        };

        // return response()->json([
        //     'data' => $data
        // ]);
    }
}
