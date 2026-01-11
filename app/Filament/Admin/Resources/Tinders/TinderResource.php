<?php

namespace App\Filament\Admin\Resources\Tinders;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Tinders\Pages\ListTinders;
use App\Filament\Admin\Resources\Tinders\Pages\CreateTinder;
use App\Filament\Admin\Resources\Tinders\Pages\EditTinder;
use App\Filament\Admin\Resources\TinderResource\Pages;
use App\Filament\Admin\Resources\TinderResource\RelationManagers;
use App\Models\Tender;
use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TinderResource extends Resource
{
    protected static ?string $model = Tender::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return   __('companies');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Heading')
                    ->tabs([
                        Tab::make(__('english'))
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextInput::make('title_en')
                                    ->label(__('Title')),
                                MarkdownEditor::make('description_en')
                                    ->label(__('description_en')),
                                TextInput::make('value')->label(__('value_en')),
                                FileUpload::make('document_en')->label(__('document_en'))->enableDownload()
                                    ->multiple(),
                                DatePicker::make('tinder_date')->label(__('tinder_date')),
                                Toggle::make('status')->label(__('status'))
                            ]),
                        Tab::make(__('arabic'))
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextInput::make('title_ar')
                                    ->label(__('title_ar')),
                                MarkdownEditor::make('description_ar')
                                    ->label(__('description_ar')),
                                FileUpload::make('document_ar')->label(__('document_ar'))->enableDownload()
                                    ->multiple(),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('description'),
                TextColumn::make('value'),
//                Tables\Columns\TextColumn::make('document'),
                TextColumn::make('tinder_date'),
                TextColumn::make('created_at')
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
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
            'index' => ListTinders::route('/'),
            'create' => CreateTinder::route('/create'),
            'edit' => EditTinder::route('/{record}/edit'),
        ];
    }
}
