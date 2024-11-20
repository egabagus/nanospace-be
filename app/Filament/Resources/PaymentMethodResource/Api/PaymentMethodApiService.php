<?php
namespace App\Filament\Resources\PaymentMethodResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\PaymentMethodResource;
use Illuminate\Routing\Router;


class PaymentMethodApiService extends ApiService
{
    protected static string | null $resource = PaymentMethodResource::class;

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
