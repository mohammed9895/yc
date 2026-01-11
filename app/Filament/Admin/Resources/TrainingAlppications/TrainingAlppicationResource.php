<?php

namespace App\Filament\Admin\Resources\TrainingAlppications;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkAction;
use App\Filament\Admin\Resources\TrainingAlppications\Pages\ListTrainingAlppications;
use App\Filament\Admin\Resources\TrainingAlppications\Pages\CreateTrainingAlppication;
use App\Filament\Admin\Resources\TrainingAlppications\Pages\EditTrainingAlppication;
use App\Filament\Admin\Resources\TrainingAlppicationResource\Pages;
use App\Filament\Admin\Resources\TrainingAlppicationResource\RelationManagers;
use App\Models\EducationType;
use App\Models\EmployeeType;
use App\Models\Province;
use App\Models\TrainingApplication;
use App\Models\User;
use App\Notifications\SmsMessage;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class TrainingAlppicationResource extends Resource
{
    protected static ?string $model = TrainingApplication::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->withoutGlobalScopes();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required(),
                TextInput::make('province_id')->label(__('province'))
                    ->required(),
                TextInput::make('education_type_id')->label(__('filament::users.degree'))
                    ->required(),
                TextInput::make('employee_type_id')->label(__('filament::users.work'))
                    ->required(),
                FileUpload::make('cv')
                    ->enableDownload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label(__('User'))
                    ->searchable()
                    ->url(fn ($record) => UserResource::getUrl('view', [$record->user_id]))
                    ->openUrlInNewTab(),
                TextColumn::make('user.birth_date')->label(__('Age'))->formatStateUsing(fn (string $state): string => Carbon::parse($state)->age),
                TextColumn::make('province.name')->label(__('province')),
                TextColumn::make('educationType.name')->label(__('filament::users.degree')),
                TextColumn::make('employeeType.name')->label(__('filament::users.work')),
                TextColumn::make('cv')->label(__('CV'))->url(fn ($record) => 'https://yc.om/storage/' . $record->cv)->openUrlInNewTab()->prefix('https://yc.om/storage/'),
                TextColumn::make('created_at')
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('province_id')->searchable()->options(Province::all()->pluck('name', 'id'))->label(__('province'))->multiple(),
                SelectFilter::make('education_type_id')->searchable()->options(EducationType::all()->pluck('name', 'id'))->label(__('filament::users.degree'))->multiple(),
                SelectFilter::make('employee_type_id')->searchable()->options(EmployeeType::all()->pluck('name', 'id'))->label(__('filament::users.work'))->multiple(),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('download')->action('approve')
                    ->label(__('Download CV'))
                    ->action(function (TrainingApplication $record) {
                        $outputFile = Storage::disk('local')->path("/public/" .$record->cv);
                        return Response::download($outputFile, $record->user->name . '_cv.pdf');
                    }),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
                ExportBulkAction::make(),


                BulkAction::make('reject')
                    ->label(__('reject'))
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {

                            $user = User::where('id', $record->user_id)->first();

                            $sms = new SmsMessage;
                            if ($user->preferred_language == 'ar') {
                                $sms->to($user->phone)
                                    ->message('نشكركم على تفاعلكم و تسجيلكم في إعلان المتدربين، ونتعذر منكم لعدم قبولكم بسبب محدودية العدد المطلوب، ونتمنى تكونوا دائمًا جزء من برامجنا وفعالياتنا خلال الفترة القادمة.')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message('We appreciate your interaction and application in the training announcement. However, we do regret to inform you that you have not been shortlisted this time due to the limited numbers required. We hope that you will always be part of our programs and events during the coming period.')
                                    ->lang($user->preferred_language)
                                    ->send();
                            }

                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-check-circle')
                    ->color('danger')
                    ->requiresConfirmation(),
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
            'index' => ListTrainingAlppications::route('/'),
            'create' => CreateTrainingAlppication::route('/create'),
            'edit' => EditTrainingAlppication::route('/{record}/edit'),
        ];
    }
}
