<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardingHouseResource\Pages;
use App\Filament\Resources\BoardingHouseResource\RelationManagers;
use App\Models\BoardingHouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;


class BoardingHouseResource extends Resource
{
    protected static ?string $model = BoardingHouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationGroup = 'Boarding House Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Informasi Umum')
                        ->schema([
                            Forms\Components\FileUpload::make('thumbnail')
                                ->image()
                                ->directory('Boarding_House')
                                ->required(),

                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->lazy() // hanya trigger saat user selesai input (blur)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $set('slug', Str::slug($state));
                                }),

                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->dehydrated(true), // tetap disimpan ke database meski disabled

                            Forms\Components\Select::make('city_id')
                                ->relationship('city', 'name')
                                ->required(),

                            Forms\Components\Select::make('category_id')
                                ->label('Kategori')
                                ->relationship('category', 'name')
                                ->required()
                                ->native(false),

                            Forms\Components\RichEditor::make('description')
                                ->required(),

                            Forms\Components\TextInput::make('price')
                                ->numeric()
                                ->prefix('IDR')
                                ->required(),

                            Forms\Components\TextArea::make('address')
                                ->required()
                        ]),

                    Tabs\Tab::make('Bonus ngekost')
                        ->schema([
                            Forms\Components\Repeater::make('bonuses')
                                ->relationship('bonuses')
                                ->schema([
                                    Forms\Components\FileUpload::make('image')
                                        ->image()
                                        ->directory('bonuses')
                                        ->required(),

                                    Forms\Components\TextInput::make('name')
                                        ->required(),

                                    Forms\Components\TextInput::make('description')
                                        ->required(),
                                ])
                        ]),

                    Tabs\Tab::make('Kamar')
                        ->schema([
                            Forms\Components\Repeater::make('rooms')
                                ->relationship('rooms')
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->required(),

                                    Forms\Components\TextInput::make('room_type')
                                        ->required(),

                                    Forms\Components\TextInput::make('square_feet')
                                        ->numeric()
                                        ->required(),

                                    Forms\Components\TextInput::make('capacity')
                                        ->numeric()
                                        ->required(),

                                    Forms\Components\TextInput::make('price_per_month')
                                        ->numeric()
                                        ->prefix('IDR')
                                        ->required(),

                                    Forms\Components\Toggle::make('is_available')
                                        ->required(),

                                    Forms\Components\Repeater::make('images')
                                        ->relationship('images')
                                        ->schema([
                                            Forms\Components\FileUpload::make('image')
                                                ->image()
                                                ->directory('rooms')
                                                ->required(),
                                        ])
                                ])
                        ]),
                ])->columnSpan(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('city.name'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\ImageColumn::make('thumbnail'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListBoardingHouses::route('/'),
            'create' => Pages\CreateBoardingHouse::route('/create'),
            'edit' => Pages\EditBoardingHouse::route('/{record}/edit'),
        ];
    }
}
