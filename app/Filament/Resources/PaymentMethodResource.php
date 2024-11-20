<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentMethodResource\Pages;
use App\Filament\Resources\PaymentMethodResource\RelationManagers;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Payment Method Name'),

                TextInput::make('value')
                    ->required()
                    ->label('Number'),

                Textarea::make('desc')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Method Name')
                    ->searchable(),

                TextColumn::make('value')
                    ->label('Value')
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
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
            'index' => Pages\ListPaymentMethods::route('/'),
            'create' => Pages\CreatePaymentMethod::route('/create'),
            'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }
}
