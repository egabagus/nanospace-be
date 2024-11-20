<?php

namespace App\Filament\Resources\OfficeSpaceResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\OfficeSpaceResource;
use Spatie\QueryBuilder\QueryBuilder;

class GetByCityHandler extends Handlers
{
    public static string | null $uri = '/get-by-city/{city}';
    public static string | null $resource = OfficeSpaceResource::class;

    public static function getMethod()
    {
        return Handlers::GET;
    }

    public function handler(Request $request)
    {
        $city = $request->route('city');

        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->whereRelation('city', 'slug', $city)
        )->with('city', 'benefits', 'photos')
            ->get();
        // dd($query);

        if (!$query) return static::sendNotFoundResponse();

        // if ($query->photos->isNotEmpty()) {
        //     foreach ($query->photos as $key => $value) {
        //         $data['photos'][] = [
        //             'id'        => $value->id,
        //             'photo'     => $value->photo
        //         ];
        //     }
        // } else {
        //     $data['photos'] = null;
        // }

        // if ($query->benefits) {
        //     foreach ($query->benefits as $key => $value) {
        //         $query['benefits'][] = [
        //             'id'   => $value->id,
        //             'name' => $value->name,
        //             'icon' => $value->icon,
        //         ];
        //     }
        // } else {
        //     $query['benefits'] = null;
        // }

        // if ($query->city) {
        //     $query['city'] = [
        //         'id'    => $query->city->id,
        //         'name'  => $query->city->name,
        //         'slug'  => $query->city->slug,
        //         'photo' => $query->city->photo,
        //     ];
        // } else {
        //     $query['city'] = null;
        // }

        // return $query;

        return [
            'data' => $query
        ];
    }
}
