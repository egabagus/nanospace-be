<?php
namespace App\Filament\Resources\BookingTransactionResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\BookingTransactionResource;
use Illuminate\Routing\Router;


class BookingTransactionApiService extends ApiService
{
    protected static string | null $resource = BookingTransactionResource::class;

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
