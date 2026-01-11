<?php

namespace App\Filament\Admin\Resources\Slots\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use App\Models\Slot;
use App\Models\User;
use App\Models\Workshop;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';

    protected static ?string $recordTitleAttribute = 'user_id';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('workshop_id')->options(Workshop::all()->pluck('title', 'id'))->searchable()->label('Workshop')
                    ->required(),
                Select::make('slot_id')->options(Slot::all()->pluck('name', 'id'))->searchable()->label('Slot')
                    ->required(),
                Select::make('user_id')->options(User::all()->pluck('name', 'id'))->searchable()->label('User')
                    ->required(),
                TextInput::make('reasone')
                    ->required()
                    ->maxLength(255),
                TextInput::make('rejection_message')
                    ->maxLength(255),
                Select::make('status')->options([
                    0 => 'Waiting',
                    1 => 'Rejected',
                    2 => 'Approvied'
                ])->searchable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('workshop.title'),
                TextColumn::make('slot.name'),
                TextColumn::make('user.name'),
                TextColumn::make('reasone'),
                TextColumn::make('rejection_message'),
                BadgeColumn::make('status')->enum([
                    0 => 'Waiting',
                    1 => 'Rejected',
                    2 => 'Approvied'
                ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
