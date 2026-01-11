<?php

namespace App\Filament\Admin\Resources\Attendees;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Admin\Resources\Attendees\Pages\ListAttendees;
use App\Filament\Admin\Resources\Attendees\Pages\CreateAttendees;
use App\Filament\Admin\Resources\Attendees\Pages\EditAttendees;
use App\Filament\Admin\Resources\AttendeesResource\Pages;
use App\Filament\Admin\Resources\AttendeesResource\RelationManagers;
use App\Models\Attendees;
use App\Models\Slot;
use App\Models\Workshop;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class AttendeesResource extends Resource
{
    protected static ?string $model = Attendees::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('slot.name'),
                TextColumn::make('attendance')
                    ->formatStateUsing(function ($state) {
                        if ($state == 1) {
                            return 'Present';
                        }
                        else {
                            return 'Absent';
                        }
                    })
                    ->colors([
                        'success' => 1,
                        'danger' => 0,
                    ]),
                TextColumn::make('date')
                    ->dateTime(),
                TextColumn::make('created_at')
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('attendance')
                    ->options([
                        1 => 'Present',
                        0 => 'Absent',
                    ]),
                Filter::make('workshop_id')
                    ->schema([
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
                ExportBulkAction::make(),
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required(),
                TextInput::make('slot_id')
                    ->required(),
                TextInput::make('attendance')
                    ->required(),
                DateTimePicker::make('date')
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
            'index' => ListAttendees::route('/'),
            'create' => CreateAttendees::route('/create'),
            'edit' => EditAttendees::route('/{record}/edit'),
        ];
    }
}
