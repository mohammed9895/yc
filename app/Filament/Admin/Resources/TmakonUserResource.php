<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TmakonUserResource\Pages;
use App\Filament\Admin\Resources\TmakonUserResource\RelationManagers;
use App\Models\TmakonCategory;
use App\Models\TmakonUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TmakonUserResource extends Resource
{

    use Translatable;

    protected static ?string $model = TmakonUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\FileUpload::make('image')->required(),
                Forms\Components\Select::make('tmakon_category_id')
                    ->options(TmakonCategory::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('job'),
                Forms\Components\TextInput::make('email'),
                Forms\Components\TextInput::make('phone'),
                Forms\Components\FileUpload::make('cv'),
                Forms\Components\Repeater::make('social_media_links')->schema([
                    Forms\Components\Select::make('platform')->options([
                        "linkedin" => "LinkedIn",
                        "twitter" => "Twitter",
                        "facebook" => "Facebook",
                        "instagram" => "Instagram",
                        "youtube" => "YouTube",
                    ]),
                    Forms\Components\TextInput::make('link'),
                ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListTmakonUsers::route('/'),
            'create' => Pages\CreateTmakonUser::route('/create'),
            'edit' => Pages\EditTmakonUser::route('/{record}/edit'),
        ];
    }
}
