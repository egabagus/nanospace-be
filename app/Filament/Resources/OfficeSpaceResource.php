<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficeSpaceResource\Api\Transformers\OfficeSpaceTransformer;
use App\Filament\Resources\OfficeSpaceResource\Pages;
use App\Filament\Resources\OfficeSpaceResource\RelationManagers;
use App\Models\City;
use App\Models\OfficeSpace;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfficeSpaceResource extends Resource
{
    protected static ?string $model = OfficeSpace::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->placeholder('Space Name')
                    ->required(),

                Select::make('city_id')
                    ->label('City')
                    ->placeholder('Select City')
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => City::where('name', 'like', "%{$search}%")->limit(5)->pluck('name', 'id')->toArray())
                    ->getOptionLabelUsing(fn($value): ?string => City::find($value)?->name)
                    ->required(),

                TextInput::make('price')
                    ->numeric()
                    ->required(),

                TextInput::make('duration')
                    ->numeric()
                    ->required(),

                Textarea::make('about')
                    ->autosize(),

                Textarea::make('address')
                    ->autosize()
                    ->required(),

                FileUpload::make('thumbnail')
                    ->directory('thumbnail')
                    ->required(),

                Section::make([
                    Tabs::make('Tabs')
                        ->tabs([
                            Tab::make('Photos')
                                ->schema([
                                    TableRepeater::make('photos')
                                        ->relationship()
                                        ->headers([
                                            Header::make('photo')->width('100%')
                                                ->align(Alignment::Center),
                                            Header::make('action')->width('10%')
                                                ->align(Alignment::Center),
                                        ])
                                        ->schema([
                                            FileUpload::make('photo')
                                                ->directory('photos')
                                                ->required(),
                                        ])
                                ]),
                            Tab::make('Benefits')
                                ->schema([
                                    TableRepeater::make('benefits')
                                        ->relationship()
                                        ->headers([
                                            Header::make('name')->width('50%')
                                                ->align(Alignment::Center),
                                            Header::make('icon')->width('50%')
                                                ->align(Alignment::Center),
                                            Header::make('action')->width('10%')
                                                ->align(Alignment::Center),
                                        ])
                                        ->schema([
                                            TextInput::make('name')
                                                ->required(),

                                            TextInput::make('icon')
                                                ->label('Icon Url')
                                        ])
                                ]),

                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail'),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('city.name')
                    ->searchable(),
                TextColumn::make('price')
                    ->money('IDR'),
                ToggleColumn::make('is_open'),
                TextColumn::make('is_full')
                    ->label('Status')
                    ->getStateUsing(fn(OfficeSpace $record) => match ($record->is_full) {
                        0 => 'Available',
                        1 => 'Full Booked',
                        default => 'Unknown',
                    })
                    ->extraAttributes([
                        'style' => 'color: blue;'
                    ])->badge()
                    ->colors([
                        'success' => fn($state) => $state === 'Available', // Warna hijau untuk 'Available'
                        'danger' => fn($state) => $state === 'Full Booked', // Warna merah untuk 'Full Booked'
                        'secondary' => fn($state) => $state === 'Unknown', // Warna abu-abu untuk 'Unknown'
                    ])
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListOfficeSpaces::route('/'),
            'create' => Pages\CreateOfficeSpace::route('/create'),
            'edit' => Pages\EditOfficeSpace::route('/{record}/edit'),
        ];
    }

    public static function getApiTransformer()
    {
        return OfficeSpaceTransformer::class;
    }
}
