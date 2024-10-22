<?php

namespace App\Filament\Cp\Pages;

use App\Models\Attendees;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MyAttendees extends Page implements HasTable
{


    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.my-attendees';

    public static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public function getTitle(): string
    {
        return   __('filament::yc.my_attendees');
    }

    public static function getNavigationLabel(): string
    {
        return   __('filament::yc.my_attendees');
    }

    use InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return Attendees::query()->where('user_id', '=', Auth::id())->with('slot.workshop');
    }
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('slot.workshop.title')
                ->searchable()
                ->label(__('filament::workshop.title')),
            TextColumn::make('attendance')
                ->badge()
                ->formatStateUsing(fn($state) => match($state) {
                    0 => __('filament::yc.absent'),
                    1 => __('filament::yc.present'),
                })
                ->colors([
                    'success' => static fn ($state): bool => $state === 1,
                    'danger' => static fn ($state): bool => $state === 0,
                ])
                ->searchable()
                ->label(__('filament::yc.attendees')),
            TextColumn::make('slot.name')
                ->label(__('filament::yc.slot'))
                ->searchable(),
            TextColumn::make('date')
                ->date('M, d Y')
                ->label(__('filament::yc.date'))
                ->searchable(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('attendance')
                ->label(__('filament::yc.present'))
                ->query(fn (Builder $query): Builder => $query->where('attendance', 1))->toggle(),

            Filter::make('slot')
                ->form([
                    Select::make('slot')->options(Attendees::join('slots', 'attendees.slot_id', '=', 'slots.id')->where('user_id', '=', Auth::id())->pluck('slots.name', 'slots.id'))->searchable()->label(__('filament::yc.slot')),
                ])->query(function (Builder $query, array $data): Builder {

                    if ($data['slot'] == null) {
                        return $query;
                    } else {
                        return $query
                            ->where(
                                'slot_id',
                                $data['slot'],
                            );
                    }
                }),


            Filter::make('date')
                ->form([
                    DatePicker::make('created_from')->label(__('filament::yc.created_from')),
                    DatePicker::make('created_until')->label(__('filament::yc.created_until')),
                ])
                ->label(__('filament::yc.date'))
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                        );
                })
        ];
    }

    protected function getTableActions(): array
    {
        return [];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }

}
