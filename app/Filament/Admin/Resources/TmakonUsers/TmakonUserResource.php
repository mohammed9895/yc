<?php

namespace App\Filament\Admin\Resources\TmakonUsers;

use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\TmakonUsers\Pages\ListTmakonUsers;
use App\Filament\Admin\Resources\TmakonUsers\Pages\CreateTmakonUser;
use App\Filament\Admin\Resources\TmakonUsers\Pages\EditTmakonUser;
use App\Filament\Admin\Resources\TmakonUserResource\Pages;
use App\Filament\Admin\Resources\TmakonUserResource\RelationManagers;
use App\Models\TmakonCategory;
use App\Models\TmakonUser;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TmakonUserResource extends Resource
{

    use Translatable;

    protected static ?string $model = TmakonUser::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                FileUpload::make('image')->required(),
                Select::make('tmakon_category_id')
                    ->options(TmakonCategory::all()->pluck('name', 'id'))
                    ->required(),
                TextInput::make('job'),
                TextInput::make('email'),
                TextInput::make('phone'),
                FileUpload::make('cv'),
                Repeater::make('social_media_links')->schema([
                    Select::make('platform')->options([
                        "linkedin" => "LinkedIn",
                        "twitter" => "Twitter",
                        "facebook" => "Facebook",
                        "instagram" => "Instagram",
                        "youtube" => "YouTube",
                    ]),
                    TextInput::make('link'),
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListTmakonUsers::route('/'),
            'create' => CreateTmakonUser::route('/create'),
            'edit' => EditTmakonUser::route('/{record}/edit'),
        ];
    }
}
