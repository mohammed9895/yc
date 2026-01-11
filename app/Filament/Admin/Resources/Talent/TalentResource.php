<?php

namespace App\Filament\Admin\Resources\Talent;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Talent\Pages\ListTalent;
use App\Filament\Admin\Resources\Talent\Pages\CreateTalent;
use App\Filament\Admin\Resources\Talent\Pages\EditTalent;
use App\Filament\Admin\Resources\TalentResource\Pages;
use App\Filament\Admin\Resources\TalentResource\RelationManagers;
use App\Models\Talent;
use App\Models\TalentType;
use App\Models\User;
use App\Notifications\SmsMessage;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class TalentResource extends Resource
{
    protected static ?string $model = Talent::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string | \UnitEnum | null $navigationGroup = 'Manjam';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make(__('General Information'))
                        ->schema([
                            Select::make('user_id')
                                ->label(__('User'))
                                ->options(User::all()->pluck('name', 'id'))
                                ->searchable()
                                ->getSearchResultsUsing(fn (string $search) => User::where('email', 'like', "%{$search}%")->limit(10)->pluck('name', 'id'))
                                ->label('User')
                                ->required(),
                            Select::make('talent_type_id')
                                ->label(__('Talent Type'))
                                ->searchable()
                                ->options(TalentType::pluck('name', 'id'))
                                ->required(),
                            TextInput::make('talent_sub_type')
                                ->label(__('Talent Sub Type'))
                                ->required(),
                            TextInput::make('purpose')->required(),
                        ]),
                    Step::make(__('Video and Images'))
                        ->schema([
                            FileUpload::make('video')
                                ->panelAspectRatio('2:1')
                                ->required(),
                            FileUpload::make('personal_image')->required()->image(),
                        ]),
                    Step::make(__('Contact Information'))
                        ->schema([
                            TextInput::make('phone')->required()->tel(),
                            TextInput::make('email')->required()->email(),
                            TagsInput::make('social_media_links')->required(),
                        ]),
                ])
                    ->columns(1)
                    ->columnSpanFull()
                    ->submitAction(new HtmlString(html: '
                        <button type="submit" class="filament-button filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2rem] px-3 text-sm text-white shadow focus:ring-white border-transparent bg-manjam_primary hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">Register Now
                        </button>')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn ($record) => UserResource::getUrl('view', [$record->user_id]))
                    ->openUrlInNewTab(),
                TextColumn::make('talentType.name'),
                TextColumn::make('talent_sub_type'),
                TextColumn::make('purpose'),
                ImageColumn::make('personal_image'),
            ])
            ->filters([
                SelectFilter::make('talent_type_id')->options(TalentType::all()->pluck('name', 'id'))->searchable()
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('Interview')
                    ->action(function (Talent $record, array $data) {
                    $user = User::where('id', $record->user_id)->first();
                    $sms = new SmsMessage;
                    if ($user->preferred_language == 'ar') {
                        $sms->to($user->phone)
                            ->message('أهلا بصديق المركز ' . $user->name . 'يسرنا اعلامك بأنك تم اختيار اسمك لإجراء مقابلة لبرنامج منجم المواهب بتاريخ ' . $data['date_time'])
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Hello friend ' . $user->name . ' We are pleased to inform you that you have been accepted for interview in Talent Manjam in ' .  $data['date_time'])
                            ->lang($user->preferred_language)
                            ->send();
                    }
                    $record->update(['status' => 1]);
                })
                    ->hidden(fn (Talent $record) => $record->status === 1)
                    ->color('warning')
                    ->icon('heroicon-o-check-circle')
                ->schema([
                    DateTimePicker::make('date_time'),
                ]),
                Action::make('Reject')->action(function (Talent $record) {
                    $user = User::where('id', $record->user_id)->first();
                    $sms = new SmsMessage;
                    if ($user->preferred_language == 'ar') {
                        $sms->to($user->phone)
                            ->message('أهلا بصديق المركز ' . $user->name . 'يؤسفنا اعلامك بأن لم يتم قبولك في برنامج منجم للمواهب')
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Hello friend ' . $user->name . 'We are sorry to inform you that you have been rejected from Talent Manjam Program')
                            ->lang($user->preferred_language)
                            ->send();
                    }
                    $record->update(['status' => 3]);
                })->color('danger')
                    ->hidden(fn (Talent $record) => $record->status === 3)
                    ->icon('heroicon-o-x-circle'),
                Action::make('Publish')->action(function (Talent $record) {
                    $user = User::where('id', $record->user_id)->first();
                    $sms = new SmsMessage;
                    if ($user->preferred_language == 'ar') {
                        $sms->to($user->phone)
                            ->message('أهلا بصديق المركز ' . $user->name . 'يسرنا اعلامك بأنك تم اختيارك لبرنامج منجم المواهب')
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Hello friend ' . $user->name . 'We are pleased to inform you that you have been accepted for Talent Manjam Program')
                            ->lang($user->preferred_language)
                            ->send();
                    }
                    $record->update(['status' => 2]);
                })
                    ->color('success')
                    ->hidden(fn (Talent $record) => $record->status === 2)
                    ->icon('heroicon-o-check-circle'),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
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
            'index' => ListTalent::route('/'),
            'create' => CreateTalent::route('/create'),
            'edit' => EditTalent::route('/{record}/edit'),
        ];
    }
}
