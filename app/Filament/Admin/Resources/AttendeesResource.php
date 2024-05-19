<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AttendeesResource\Pages;
use App\Filament\Admin\Resources\AttendeesResource\RelationManagers;
use App\Models\Attendees;
use App\Models\Slot;
use App\Models\Workshop;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class AttendeesResource extends Resource
{
    protected static ?string $model = Attendees::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('slot.name'),
                Tables\Columns\BadgeColumn::make('attendance')
                    ->enum([
                        1 => 'Present',
                        0 => 'Absent',
                    ])
                    ->colors([
                        'success' => 1,
                        'danger' => 0,
                    ]),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('attendance')
                    ->options([
                        1 => 'Present',
                        0 => 'Absent',
                    ]),
                Filter::make('workshop_id')
                    ->form([
                        Select::make('workshop_id')
                            ->label(__('Workshop'))
                            ->options(Workshop::all()->pluck('title', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('slot_id', null)),
                        Select::make('slot_id')
                            ->label(__('slot'))
                            ->options(function (callable $get) {
                                $workshop = Workshop::find($get('workshop_id'));
                                if (!$workshop) {
                                    return Slot::all()->pluck('name', 'id');
                                }
                                return $workshop->slots->pluck('name', 'id');
                            })
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['slot_id'],
                                fn(Builder $query, $date): Builder => $query->where('slot_id', '=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make(),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required(),
                Forms\Components\TextInput::make('slot_id')
                    ->required(),
                Forms\Components\TextInput::make('attendance')
                    ->required(),
                Forms\Components\DateTimePicker::make('date')
                    ->required(),
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
            'index' => Pages\ListAttendees::route('/'),
            'create' => Pages\CreateAttendees::route('/create'),
            'edit' => Pages\EditAttendees::route('/{record}/edit'),
        ];
    }
}
