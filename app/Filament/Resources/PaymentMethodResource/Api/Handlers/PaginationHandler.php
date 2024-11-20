<?php

namespace App\Filament\Resources\PaymentMethodResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filament\Resources\PaymentMethodResource;

class PaginationHandler extends Handlers
{
    public static string | null $uri = '/';
    public static string | null $resource = PaymentMethodResource::class;


    public function handler()
    {
        $query = static::getEloquentQuery();
        $model = static::getModel();

        $query = QueryBuilder::for($query)
            ->allowedFields($this->getAllowedFields() ?? [])
            ->allowedSorts($this->getAllowedSorts() ?? [])
            ->allowedFilters($this->getAllowedFilters() ?? [])
            ->allowedIncludes($this->getAllowedIncludes() ?? [])
            ->paginate(request()->query('per_page'))
            ->where('status', 1);

        return static::getApiTransformer()::collection($query);
    }
}
