<?php
namespace App\Filament\Resources\OfficeSpaceResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\OfficeSpaceResource;
use Illuminate\Routing\Router;


class OfficeSpaceApiService extends ApiService
{
    protected static string | null $resource = OfficeSpaceResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
