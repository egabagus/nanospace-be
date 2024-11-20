<?php

namespace App\Filament\Resources\BookingTransactionResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\BookingTransactionResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateHandler extends Handlers
{
    public static string | null $uri = '/';
    public static string | null $resource = BookingTransactionResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    public function handler(Request $request)
    {
        DB::beginTransaction();
        try {
            $model = new (static::getModel());

            $start = Carbon::parse($request->start_date);
            $duration = $request->duration;
            $end = $start->addDays($duration);

            $model->name            = $request->name;
            $model->phone           = $request->phone;
            $model->office_space_id = $request->office_space_id;
            $model->total_amount    = $request->total_amount;
            $model->duration        = $duration;
            $model->start           = $request->start_date;
            $model->end             = $end->toDateString();

            $model->save();

            DB::commit();
            return static::sendSuccessResponse($model, "Successfully Create Resource");
        } catch (Throwable $th) {
            DB::rollBack();
            return static::sendErrorResponse($th->getMessage());
        }
    }
}
