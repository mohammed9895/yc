<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ScheduleResource\Pages;
use App\Filament\Admin\Resources\ScheduleResource\RelationManagers;
use App\Models\Hall;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return   __('halls');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('hall_id')
                    ->options(Hall::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\DatePicker::make('starts_at')
                    ->native(false)
                    ->required(),
                Forms\Components\DatePicker::make('ends_at')
                    ->native(false)
                    ->required(),
                Forms\Components\TimePicker::make('monday_starts_at')->native(false),
                Forms\Components\TimePicker::make('monday_ends_at')->native(false),
                Forms\Components\TimePicker::make('tuesday_starts_at')->native(false),
                Forms\Components\TimePicker::make('tuesday_ends_at')->native(false),
                Forms\Components\TimePicker::make('wednesday_starts_at')->native(false),
                Forms\Components\TimePicker::make('wednesday_ends_at')->native(false),
                Forms\Components\TimePicker::make('thursday_starts_at')->native(false),
                Forms\Components\TimePicker::make('thursday_ends_at')->native(false),
                Forms\Components\TimePicker::make('friday_starts_at')->native(false),
                Forms\Components\TimePicker::make('friday_ends_at')->native(false),
                Forms\Components\TimePicker::make('saturday_starts_at')->native(false),
                Forms\Components\TimePicker::make('saturday_ends_at')->native(false),
                Forms\Components\TimePicker::make('sunday_starts_at')->native(false),
                Forms\Components\TimePicker::make('sunday_ends_at')->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hall.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('monday_starts_at'),
                Tables\Columns\TextColumn::make('monday_ends_at'),
                Tables\Columns\TextColumn::make('tuesday_starts_at'),
                Tables\Columns\TextColumn::make('tuesday_ends_at'),
                Tables\Columns\TextColumn::make('wednesday_starts_at'),
                Tables\Columns\TextColumn::make('wednesday_ends_at'),
                Tables\Columns\TextColumn::make('thursday_starts_at'),
                Tables\Columns\TextColumn::make('thursday_ends_at'),
                Tables\Columns\TextColumn::make('friday_starts_at'),
                Tables\Columns\TextColumn::make('friday_ends_at'),
                Tables\Columns\TextColumn::make('saturday_starts_at'),
                Tables\Columns\TextColumn::make('saturday_ends_at'),
                Tables\Columns\TextColumn::make('sunday_starts_at'),
                Tables\Columns\TextColumn::make('sunday_ends_at'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
