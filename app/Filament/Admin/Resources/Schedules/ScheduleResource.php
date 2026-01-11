<?php

namespace App\Filament\Admin\Resources\Schedules;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Schedules\Pages\ListSchedules;
use App\Filament\Admin\Resources\Schedules\Pages\CreateSchedule;
use App\Filament\Admin\Resources\Schedules\Pages\EditSchedule;
use App\Filament\Admin\Resources\ScheduleResource\Pages;
use App\Filament\Admin\Resources\ScheduleResource\RelationManagers;
use App\Models\Hall;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return   __('halls');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('hall_id')
                    ->options(Hall::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                DatePicker::make('starts_at')
                    ->native(false)
                    ->required(),
                DatePicker::make('ends_at')
                    ->native(false)
                    ->required(),
                TimePicker::make('monday_starts_at')->native(false),
                TimePicker::make('monday_ends_at')->native(false),
                TimePicker::make('tuesday_starts_at')->native(false),
                TimePicker::make('tuesday_ends_at')->native(false),
                TimePicker::make('wednesday_starts_at')->native(false),
                TimePicker::make('wednesday_ends_at')->native(false),
                TimePicker::make('thursday_starts_at')->native(false),
                TimePicker::make('thursday_ends_at')->native(false),
                TimePicker::make('friday_starts_at')->native(false),
                TimePicker::make('friday_ends_at')->native(false),
                TimePicker::make('saturday_starts_at')->native(false),
                TimePicker::make('saturday_ends_at')->native(false),
                TimePicker::make('sunday_starts_at')->native(false),
                TimePicker::make('sunday_ends_at')->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hall.name')
                    ->sortable(),
                TextColumn::make('starts_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('ends_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('monday_starts_at'),
                TextColumn::make('monday_ends_at'),
                TextColumn::make('tuesday_starts_at'),
                TextColumn::make('tuesday_ends_at'),
                TextColumn::make('wednesday_starts_at'),
                TextColumn::make('wednesday_ends_at'),
                TextColumn::make('thursday_starts_at'),
                TextColumn::make('thursday_ends_at'),
                TextColumn::make('friday_starts_at'),
                TextColumn::make('friday_ends_at'),
                TextColumn::make('saturday_starts_at'),
                TextColumn::make('saturday_ends_at'),
                TextColumn::make('sunday_starts_at'),
                TextColumn::make('sunday_ends_at'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ListSchedules::route('/'),
            'create' => CreateSchedule::route('/create'),
            'edit' => EditSchedule::route('/{record}/edit'),
        ];
    }
}
