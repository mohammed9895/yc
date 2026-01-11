<?php

namespace App\Filament\Admin\Resources\Slots;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Slots\RelationManagers\BookingsRelationManager;
use App\Filament\Admin\Resources\Slots\Pages\ListSlots;
use App\Filament\Admin\Resources\Slots\Pages\CreateSlot;
use App\Filament\Admin\Resources\Slots\Pages\EditSlot;
use App\Filament\Admin\Resources\SlotResource\Pages;
use App\Filament\Admin\Resources\SlotResource\RelationManagers;
use App\Models\Slot;
use App\Models\Workshop;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SlotResource extends Resource
{
    // use HasPageShield;
    protected static ?string $model = Slot::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('slots');
    }

    public static function getPluralModelLabel(): string
    {
        return __('slots');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('workshop_id')
                    ->label(__('Workshop'))
                    ->options(Workshop::all()->pluck('title', 'id'))
                    ->searchable(),
                TextInput::make('name')
                    ->label(__('Name'))
                    ->maxLength(255),
                DatePicker::make('start_date')
                    ->label(__('start_date'))
                    ->minDate(now()->today())
                    ->weekStartsOnSunday()
                    ->reactive(),
                DatePicker::make('end_date')
                    ->label(__('end_date'))
                    ->minDate(function (callable $get) {
                        return Carbon::parse($get('start_date'));
                    })
                    ->weekStartsOnSunday(),
                TimePicker::make('start_time')
                    ->label(__('start_time'))
                    ->minDate(function (callable $get) {
                        if (Carbon::parse($get('start_date'))->isToday()) {
                            return now();
                        } else {
                            return null;
                        }
                    })
                    ->reactive(),
                TimePicker::make('end_time')
                    ->label(__('end_time'))
                    ->minDate(function (callable $get) {
                        return Carbon::parse($get('start_time'));
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('workshop.title')->label(__('Workshop')),
                TextColumn::make('name')->label(__('Name')),
                TextColumn::make('start_date')->label(__('start_date'))
                    ->date(),
                TextColumn::make('end_date')->label(__('end_date'))
                    ->date(),
                TextColumn::make('start_time')->label(__('start_time')),
                TextColumn::make('end_time')->label(__('end_time')),
                TextColumn::make('created_at')->label(__('created_at'))
                    ->dateTime(),
                TextColumn::make('updated_at')->label(__('updated_at'))
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
            BookingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSlots::route('/'),
            'create' => CreateSlot::route('/create'),
            'edit' => EditSlot::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('workshops');
    }
}
