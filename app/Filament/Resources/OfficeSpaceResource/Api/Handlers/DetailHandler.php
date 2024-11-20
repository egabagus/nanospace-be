<?php

namespace App\Filament\Resources\OfficeSpaceResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\OfficeSpaceResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{slug}';
    public static string | null $resource = OfficeSpaceResource::class;


    public function handler(Request $request)
    {
        $slug = $request->route('slug');

        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where('slug', $slug)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        $transformer = static::getApiTransformer();

        return new $transformer($query);
    }
}
