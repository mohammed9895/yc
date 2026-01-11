<?php

namespace App\Filament\Admin\Resources\Tamkeens;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Tamkeens\Pages\ListTamkeens;
use App\Filament\Admin\Resources\Tamkeens\Pages\CreateTamkeen;
use App\Filament\Admin\Resources\Tamkeens\Pages\EditTamkeen;
use App\Filament\Admin\Resources\TamkeenResource\Pages;
use App\Filament\Admin\Resources\TamkeenResource\RelationManagers;
use App\Models\Tamkeen;
use App\Models\User;
use App\Notifications\SmsMessage;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class TamkeenResource extends Resource
{
    protected static ?string $model = Tamkeen::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                TagsInput::make('social_media_accounts')->required(),
                TextInput::make('linkedin_account')->required(),
                FileUpload::make('resume_attachment')->required(),
                FileUpload::make('profile_picture_attachment'),
                Select::make('skill')->options([
                    'المجال العلمي' => 'المجال العلمي',
                    'المجال الفني' => 'المجال الفني',
                    'المجال الهندسي' => 'المجال الهندسي',
                    'المجال الإعلامي' => 'المجال الإعلامي',
                    'المجال الكتابي' => 'المجال الكتابي',
                    'مجال البرمجيات' => 'مجال البرمجيات',
                    'مجال التسويق' => 'مجال التسويق',
                    'مجال التصميم' => 'مجال التصميم',
                    'المجال الحرفي' => 'المجال الحرفي',
                    'مجال التصوير' => 'مجال التصوير',
                    'مجال التجميل' => 'مجال التجميل',
                    'مجال الأزياء' => 'مجال الأزياء',
                    'المجال التقني' => 'المجال التقني',
                    'مجالات أخرى' => 'مجالات أخرى',
                ])
                    ->searchable()
                    ->required(),
                TextInput::make('primary_skill')->required(),
                TagsInput::make('other_skill'),
                TextInput::make('program_goals')->required(),
                TextInput::make('how_did_you_discover_your_skill')->required(),
                TextInput::make('skill_practice_duration')->required(),
                TextInput::make('awards_certificates')->required(),
                TextInput::make('earned_income')->required(),
                TextInput::make('freelance_experience_years')->required(),
                Select::make('freelance_experience_level')->options([
                    'Beginner' => __('Beginner'),
                    'Intermediate' => __('Intermediate'),
                    'Expert' => __('Expert'),
                ])->required()->searchable(),
                Select::make('skill_level')->options([
                    'Beginner' => __('Beginner'),
                    'Intermediate' => __('Intermediate'),
                    'Expert' => __('Expert'),
                ])->required()->searchable(),
                TextInput::make('clients_worked_with')->required(),
                TextInput::make('financial_earnings')->required(),
                TagsInput::make('achievements')->required(),
                Textarea::make('development_plan')->required(),
                Select::make('can_manage_projects')
                    ->options([
                        0 => 'No',
                        1 => 'Yes'
                    ])->required()->searchable(),
                Select::make('can_price_services_and_market_self')
                    ->options([
                        0 => 'No',
                        1 => 'Yes'
                    ])->required()->searchable(),
                Textarea::make('self_marketing_strategy'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                TextColumn::make('user.email')->label(__('email')),
                TextColumn::make('user.phone')->label(__('phone')),
                TextColumn::make('user.province.name')->label(__('province')),
                TextColumn::make('user.state.name')->label(__('state')),
                TextColumn::make('user.birth_date')->label(__('Age'))->formatStateUsing(fn(string $state
                ): string => Carbon::parse($state)->age),
//                Tables\Columns\TagsColumn::make('social_media_accounts'),
                TextColumn::make('linkedin_account'),
                TextColumn::make('skill'),
                TextColumn::make('primary_skill'),
//                Tables\Columns\TagsColumn::make('other_skill'),
                TextColumn::make('program_goals'),
                TextColumn::make('how_did_you_discover_your_skill'),
                TextColumn::make('skill_practice_duration')->date(),
                TextColumn::make('awards_certificates'),
                TextColumn::make('earned_income'),
                TextColumn::make('freelance_experience_years'),
                TextColumn::make('freelance_experience_level'),
                TextColumn::make('skill_level'),
                TextColumn::make('clients_worked_with'),
                TextColumn::make('financial_earnings'),
//                Tables\Columns\TagsColumn::make('achievements'),
                TextColumn::make('development_plan'),
                TextColumn::make('can_manage_projects')->enum(
                    [
                        1 => 'Yes',
                        0 => 'No'
                    ]
                ),
                TextColumn::make('can_price_services_and_market_self')->enum(
                    [
                        1 => 'Yes',
                        0 => 'No'
                    ]
                ),
                TextColumn::make('self_marketing_strategy'),
            ])
            ->filters([
                SelectFilter::make('skill')->options([
                    'المجال العلمي' => 'المجال العلمي',
                    'المجال الفني' => 'المجال الفني',
                    'المجال الهندسي' => 'المجال الهندسي',
                    'المجال الإعلامي' => 'المجال الإعلامي',
                    'المجال الكتابي' => 'المجال الكتابي',
                    'مجال البرمجيات' => 'مجال البرمجيات',
                    'مجال التسويق' => 'مجال التسويق',
                    'مجال التصميم' => 'مجال التصميم',
                    'المجال الحرفي' => 'المجال الحرفي',
                    'مجال التصوير' => 'مجال التصوير',
                    'مجال التجميل' => 'مجال التجميل',
                    'مجال الأزياء' => 'مجال الأزياء',
                    'المجال التقني' => 'المجال التقني',
                    'مجالات أخرى' => 'مجالات أخرى',
                ])
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('Approve')
                    ->label(__('Approve'))
                    ->action('approve')
                    ->action(function (Tamkeen $record, array $data) {
                        $user = User::where('id', $record->user_id)->first();

                        $sms = new SmsMessage;

                        if ($user->preferred_language == 'ar') {
                            $sms->to($user->phone)
                                ->message('عزيزنا المسجل تم قبولك في برنامج تمكّن ،
ننتظرك في أول ورشة تعريفية بتاريخ  23 أكتوبر ( عبر منصة الزوم)  ، وذلك في تمام  الساعة ٤:٠٠ مساءً  .')
                                ->lang($user->preferred_language)
                                ->send();
                        } else {
                            $sms->to($user->phone)
                                ->message('Dear participant, We are delighted to inform you that you have been accepted in Tamakon program. We look forward to seeing you at the orientation workshop on 23 October (via Zoom) at 4:00 PM.')
                                ->lang($user->preferred_language)
                                ->send();
                        }
                    })
                    ->icon('heroicon-o-trash')
                    ->color('success'),
            ])
            ->toolbarActions([
                ExportBulkAction::make(),
                BulkAction::make('approve')
                    ->label(__('Approve'))
                    ->action(function (Collection $records, array $data) {
                        $sms = new SmsMessage;
                        foreach ($records as $record) {
                            $user = User::where('id', $record->user_id)->first();
                            if ($user->preferred_language == 'ar') {
                                $sms->to($user->phone)
                                    ->message('عزيزنا المسجل تم قبولك في برنامج تمكّن ،
ننتظرك في أول ورشة تعريفية بتاريخ  23 أكتوبر ( عبر منصة الزوم)  ، وذلك في تمام  الساعة ٤:٠٠ مساءً  .')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message('Dear participant, We are delighted to inform you that you have been accepted in Tamakon program. We look forward to seeing you at the orientation workshop on 23 October (via Zoom) at 4:00 PM.')
                                    ->lang($user->preferred_language)
                                    ->send();
                            }
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->color('success'),
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
            'index' => ListTamkeens::route('/'),
            'create' => CreateTamkeen::route('/create'),
            'edit' => EditTamkeen::route('/{record}/edit'),
        ];
    }
}
