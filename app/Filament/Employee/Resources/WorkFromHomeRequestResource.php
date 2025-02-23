<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\WorkFromHomeRequestResource\Pages;
use App\Filament\Employee\Resources\WorkFromHomeRequestResource\RelationManagers;
use App\WorkFromHomeStatus;
use App\Models\Employee;
use App\Models\WorkFromHomeRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkFromHomeRequestResource extends Resource
{
    protected static ?string $model = WorkFromHomeRequest::class;

    protected static ?string $navigationGroup = 'HR';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employee_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('from')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('to')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
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
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->formatStateUsing(function (WorkFromHomeRequest $record) {
                        return $record->employee->first_name . ' ' . $record->employee->second_name . ' ' . $record->employee->third_name  . ' ' . $record->employee->family_name;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('from')
                    ->date()
                    ->searchable(),
                Tables\Columns\TextColumn::make('to')
                    ->date()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
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
                Tables\Actions\Action::make('reject_as_direct_manager')
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

                Tables\Actions\Action::make('accept_as_direct_manager')
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

                Tables\Actions\Action::make('reject_as_ceo')
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

                Tables\Actions\Action::make('accept_as_ceo')
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
            'index' => Pages\ListWorkFromHomeRequests::route('/'),
            'create' => Pages\CreateWorkFromHomeRequest::route('/create'),
            'edit' => Pages\EditWorkFromHomeRequest::route('/{record}/edit'),
        ];
    }
}
