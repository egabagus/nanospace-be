<?php

namespace App\Filament\Resources\OfficeSpaceResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filament\Resources\OfficeSpaceResource;

class PaginationHandler extends Handlers
{
    public static string | null $uri = '/';
    public static string | null $resource = OfficeSpaceResource::class;


    public function handler()
    {
        $query = static::getEloquentQuery();
        $model = static::getModel();

        $query = QueryBuilder::for($query)->with('city', 'benefits', 'photos')
            ->allowedFields($this->getAllowedFields() ?? [])
            ->allowedSorts($this->getAllowedSorts() ?? [])
            ->allowedFilters($this->getAllowedFilters() ?? [])
            ->allowedIncludes($this->getAllowedIncludes() ?? [])
            ->where('is_open', 1)
            ->paginate(request()->query('per_page'));

        return static::getApiTransformer()::collection($query);
    }
}
