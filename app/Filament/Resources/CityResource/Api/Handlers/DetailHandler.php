<?php

namespace App\Filament\Resources\CityResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\CityResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{slug}';
    public static string | null $resource = CityResource::class;


    public function handler(Request $request)
    {
        $slug = $request->route('slug');

        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where('slug', $slug)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        $data = [
            'id'        => $query->id,
            'name'      => $query->name,
            'slug'      => $query->slug,
            'photo'     => $query->photo,
        ];

        return $data;
        // $transformer = static::getApiTransformer();

        // return new $transformer($query);
    }
}
