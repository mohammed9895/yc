<?php

namespace App\Filament\Employee\Resources\WorkFromHomeRequests;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Employee\Resources\WorkFromHomeRequests\Pages\ListWorkFromHomeRequests;
use App\Filament\Employee\Resources\WorkFromHomeRequests\Pages\CreateWorkFromHomeRequest;
use App\Filament\Employee\Resources\WorkFromHomeRequests\Pages\EditWorkFromHomeRequest;
use App\Filament\Employee\Resources\WorkFromHomeRequestResource\Pages;
use App\Filament\Employee\Resources\WorkFromHomeRequestResource\RelationManagers;
use App\WorkFromHomeStatus;
use App\Models\Employee;
use App\Models\WorkFromHomeRequest;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkFromHomeRequestResource extends Resource
{
    protected static ?string $model = WorkFromHomeRequest::class;

    protected static string | \UnitEnum | null $navigationGroup = 'HR';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('employee_id')
                    ->required()
                    ->numeric(),
                TextInput::make('from')
                    ->required()
                    ->maxLength(255),
                TextInput::make('to')
                    ->required()
                    ->maxLength(255),
                Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $employee = Employee::where('user_id', auth()->id())->first();
                if ($employee->is_ceo) {
                    return $query;
                }
                return $query->whereHas('employee', function ($query) use ($employee) {
                    $query->where('direct_manager', $employee->id);
                });
            })
            ->columns([
                TextColumn::make('employee.first_name')
                    ->formatStateUsing(function (WorkFromHomeRequest $record) {
                        return $record->employee->first_name . ' ' . $record->employee->second_name . ' ' . $record->employee->third_name  . ' ' . $record->employee->family_name;
                    })
                    ->sortable(),
                TextColumn::make('from')
                    ->date()
                    ->searchable(),
                TextColumn::make('to')
                    ->date()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
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
                Action::make('reject_as_direct_manager')
                    ->icon('heroicon-o-x-mark')
                    ->label('Reject as Direct Manager')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->hidden(function (WorkFromHomeRequest $WorkFromHomeRequest) {
                        $employee = Employee::where('user_id', auth()->id())->first();
                        return  $employee->is_ceo || $WorkFromHomeRequest->status == WorkFromHomeStatus::RejectedByDirectManger;
                    })
                    ->action(function (WorkFromHomeRequest $record) {
                        $record->status = WorkFromHomeStatus::RejectedByDirectManger;
                        $record->save();
                        return Notification::make('success')
                            ->title('Success')
                            ->body('Grate, WorkFromHomeRequest Rejected Successfully')
                            ->success()
                            ->send();
                    }),

                Action::make('accept_as_direct_manager')
                    ->icon('heroicon-o-check')
                    ->label('Accept as Direct Manager')
                    ->color('success')
                    ->hidden(function (WorkFromHomeRequest $WorkFromHomeRequest) {
                        $employee = Employee::where('user_id', auth()->id())->first();
                        return $employee->is_ceo || $WorkFromHomeRequest->status == WorkFromHomeStatus::AcceptedByDirectManger;
                    })
                    ->action(function (WorkFromHomeRequest $record) {
                        $record->status = WorkFromHomeStatus::AcceptedByDirectManger;
                        $record->save();
                        return Notification::make('success')
                            ->title('Success')
                            ->body('Grate, WorkFromHomeRequest Accepted Successfully')
                            ->success()
                            ->send();
                    }),

                Action::make('reject_as_ceo')
                    ->icon('heroicon-o-x-mark')
                    ->label('Reject as CEO')
                    ->requiresConfirmation()
                    ->visible(function (WorkFromHomeRequest $record) {
                        $employee = Employee::where('user_id', auth()->id())->first();
                        if ($employee->is_ceo && ($record->status == WorkFromHomeStatus::AcceptedByDirectManger || $record->status == WorkFromHomeStatus::AcceptedByCEO)) {
                            return true;
                        }
                        return false;
                    })
//                    ->hidden(fn (WorkFromHomeRequest $WorkFromHomeRequest) => $WorkFromHomeRequest->status == WorkFromHomeStatus::RejectedByCEO)
                    ->color('danger')
                    ->action(function (WorkFromHomeRequest $record) {
                        $record->status = WorkFromHomeStatus::RejectedByCEO;
                        $record->save();
                        return Notification::make('success')
                            ->title('Success')
                            ->body('Grate, WorkFromHomeRequest Rejected Successfully')
                            ->success()
                            ->send();
                    }),

                Action::make('accept_as_ceo')
                    ->icon('heroicon-o-check')
                    ->label('Accept as CEO')
                    ->color('success')
                    ->visible(function (WorkFromHomeRequest $record) {
                        $employee = Employee::where('user_id', auth()->id())->first();
                        if ($employee->is_ceo && ($record->status == WorkFromHomeStatus::AcceptedByDirectManger || $record->status == WorkFromHomeStatus::RejectedByCEO)) {
                            return true;
                        }
                        return false;
                    })
//                    ->hidden(fn (WorkFromHomeRequest $WorkFromHomeRequest) => $WorkFromHomeRequest->status == WorkFromHomeStatus::AcceptedByCEO)
                    ->action(function (WorkFromHomeRequest $record) {
                        $record->status = WorkFromHomeStatus::AcceptedByCEO;
                        $record->save();
                        return Notification::make('success')
                            ->title('Success')
                            ->body('Grate, WorkFromHomeRequest Accepted Successfully')
                            ->success()
                            ->send();
                    }),
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
            'index' => ListWorkFromHomeRequests::route('/'),
            'create' => CreateWorkFromHomeRequest::route('/create'),
            'edit' => EditWorkFromHomeRequest::route('/{record}/edit'),
        ];
    }
}
