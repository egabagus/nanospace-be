<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingTransactionResource\Pages;
use App\Filament\Resources\BookingTransactionResource\RelationManagers;
use App\Models\BookingTransaction;
use App\Models\OfficeSpace;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingTransactionResource extends Resource
{
    protected static ?string $model = BookingTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                TextInput::make('booking_trx')
                    ->disabled()
                    ->label('Booking ID')
                    ->placeholder('auto'),

                TextInput::make('phone')
                    ->required(),

                Select::make('office_space_id')
                    ->required()
                    ->label('Space')
                    ->placeholder('Select Space')
                    ->searchable()
                    ->options(OfficeSpace::all()->pluck('name', 'id'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        self::displayPrice($set, $get);
                    }),

                DatePicker::make('start')
                    ->required()
                    ->format('Y-m-d')
                    ->label('Start Date'),

                DatePicker::make('end')
                    ->required()
                    ->format('Y-m-d')
                    ->label('End Date'),

                TextInput::make('duration')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        self::calculate($set, $get);
                    })
                    ->numeric(),

                TextInput::make('price')
                    ->readOnly()
                    ->dehydrated(false),

                TextInput::make('total_amount')
                    ->required()
                    ->readOnly()
                    ->numeric(),

                Select::make('is_paid')
                    ->options([
                        0 => 'Unpaid',
                        1 => 'Paid'
                    ])
                    ->required()
            ]);
    }

    protected static function displayPrice(callable $set, callable $get)
    {
        $data = OfficeSpace::find($get('office_space_id'));
        $price = $data->price;

        $set('price', $price);
    }

    protected static function calculate(callable $set, callable $get)
    {
        $price = $get('price');
        $days = $get('duration');

        $totalAmmount = $price * $days;
        // if ($days > 0) {
        //     dd($days);
        // }
        $set('total_amount', $totalAmmount);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_trx')
                    ->searchable()
                    ->label('Booking ID'),

                TextColumn::make('name')
                    ->searchable()
                    ->label('Name'),

                TextColumn::make('phone')
                    ->searchable()
                    ->label('Phone'),

                TextColumn::make('office_space.name')
                    ->searchable()
                    ->label('Office Space'),

                TextColumn::make('start')
                    ->searchable()
                    ->date(),

                TextColumn::make('end')
                    ->searchable()
                    ->date(),

                TextColumn::make('duration'),

                TextColumn::make('total_amount')
                    ->money('IDR'),

                TextColumn::make('is_paid')
                    ->label('Status')
                    ->getStateUsing(fn(BookingTransaction $record) => match ($record->is_paid) {
                        0 => 'Unpaid',
                        1 => 'Paid',
                        default => 'Unknown',
                    })
                    ->extraAttributes([
                        'style' => 'color: blue;'
                    ])->badge()
                    ->colors([
                        'success' => fn($state) => $state === 'Paid', // Warna hijau untuk 'Available'
                        'danger' => fn($state) => $state === 'Unpaid', // Warna merah untuk 'Full Booked'
                        'secondary' => fn($state) => $state === 'Unknown', // Warna abu-abu untuk 'Unknown'
                    ])
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookingTransactions::route('/'),
            'create' => Pages\CreateBookingTransaction::route('/create'),
            'edit' => Pages\EditBookingTransaction::route('/{record}/edit'),
        ];
    }
}
