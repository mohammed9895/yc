<?php

namespace App\Filament\Admin\Resources\Cybersecurities;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Cybersecurities\Pages\ListCybersecurities;
use App\Filament\Admin\Resources\Cybersecurities\Pages\CreateCybersecurity;
use App\Filament\Admin\Resources\Cybersecurities\Pages\EditCybersecurity;
use App\Filament\Admin\Resources\CybersecurityResource\Pages;
use App\Filament\Admin\Resources\CybersecurityResource\RelationManagers;
use App\Models\Cybersecurity;
use App\Models\User;
use App\Notifications\SmsMessage;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CybersecurityResource extends Resource
{
    protected static ?string $model = Cybersecurity::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Checkbox::make('tried_linux')
                    ->label('Have you tried working on Linux systems in the past?'),

                Checkbox::make('passionate_cyber_security')
                    ->label('Are you passionate about learning cyber security and the Linux operating system?'),

                Select::make('academic_professional_status')
                    ->label('What is your current academic or professional status?')
                    ->options([
                        'diploma_holder' => 'Diploma holder',
                        'senior_year_student' => 'Senior year student',
                        'fresh_graduate' => 'Fresh graduate',
                        'cyber_analyst' => 'Cyber analyst',
                        'other' => 'Other',
                    ]),

                Select::make('linux_expertise')
                    ->label('Evaluate your expertise in Linux fundamentals.')
                    ->options([
                        'zero_knowledge' => 'Zero knowledge',
                        'low_knowledge' => 'Low knowledge',
                        'medium_knowledge' => 'Medium knowledge',
                        'high_knowledge' => 'High knowledge',
                    ]),

                Checkbox::make('participated_in_workshops')
                    ->label('Have you participated in any cyber security workshops?'),

                Textarea::make('significant_project_description')
                    ->label('Please describe your most significant project related to Linux.')
                    ->maxLength(600),

                Textarea::make('motivation_participation')
                    ->label('What motivated you to participate in this program?')
                    ->maxLength(600),

                Textarea::make('reason_for_opportunity')
                    ->label('Why do you believe you deserve this opportunity?')
                    ->maxLength(600),
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
                TextColumn::make('user.phone')
                    ->label(__('phone')),
                TextColumn::make('user.email')
                    ->label(__('email')),
                TextColumn::make('user.birth_date')->label(__('Age'))->formatStateUsing(fn(string $state
                ): string => Carbon::parse($state)->age),
                BooleanColumn::make('tried_linux')
                    ->label('Tried Linux'),
                BooleanColumn::make('passionate_cyber_security')
                    ->label('Passionate about Cyber Security'),
                TextColumn::make('academic_professional_status')
                    ->label('Academic/Professional Status')
                    ->enum([
                        'diploma_holder' => 'Diploma holder',
                        'senior_year_student' => 'Senior year student',
                        'fresh_graduate' => 'Fresh graduate',
                        'cyber_analyst' => 'Cyber analyst',
                        'other' => 'Other',
                    ]),
                TextColumn::make('linux_expertise')
                    ->label('Linux Expertise')
                    ->enum([
                        'zero_knowledge' => 'Zero knowledge',
                        'low_knowledge' => 'Low knowledge',
                        'medium_knowledge' => 'Medium knowledge',
                        'high_knowledge' => 'High knowledge',
                    ]),
                BooleanColumn::make('participated_in_workshops')
                    ->label('Participated in Workshops'),
                TextColumn::make('significant_project_description')
                    ->label('Significant Project')
                    ->limit(50), // Truncate to show a preview
                TextColumn::make('motivation_participation')
                    ->label('Motivation')
                    ->limit(50), // Truncate to show a preview
                TextColumn::make('reason_for_opportunity')
                    ->label('Reason for Opportunity')
                    ->limit(50), // Truncate to show a preview
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('Approve')->action(function (Cybersecurity $record) {
                    $user = User::where('id', $record->user_id)->first();
                    $sms = new SmsMessage;
                    if ($user->preferred_language == 'ar') {
                        $sms->to($user->phone)
                            ->message('أهلا بصديق المركز '.$user->name.' '.'يسرنا إعلامك بقبولك في برنامج ( الأمن السيبراني ). نحن بانتظارك في ( 05-02-2024 ) تبدأ الورشة ( 5:00 )')
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Hello friend '.$user->name.' We are pleased to inform you that you have been accepted into the (Cybersecurity) program. We are waiting for you on (2024-02-05) The workshop begins (17:00:00)')
                            ->lang($user->preferred_language)
                            ->send();
                    }
                    $record->update(['status' => 1]);
                })
                    ->color('success')
                    ->hidden(fn(Cybersecurity $record) => $record->status === 1)
                    ->icon('heroicon-o-check-circle'),
                Action::make('reject')->action(function (Cybersecurity $record) {
                    $user = User::where('id', $record->user_id)->first();
                    $sms = new SmsMessage;
                    if ($user->preferred_language == 'ar') {
                        $sms->to($user->phone)
                            ->message('أهلا بصديق المركز، أهلًا، شكرًا لتسجيلك في برنامج الأمن السيبراني . نعتذر عن عدم قبولك ضمن المشاركين نظرًا للإقبال الواسع على المقاعد و اكتمال العدد المطلوب. نراكم في برامجنا القادمة.')
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Hello, Thank you for registering for the Cybersecurity program. We apologize for being unable to accept you among the participants due to the high demand for registration and reaching the specified program limit. See you soon at our next programs.')
                            ->lang($user->preferred_language)
                            ->send();
                    }
                    $record->update(['status' => 2]);
                })
                    ->color('danger')
                    ->hidden(fn(Cybersecurity $record) => $record->status === 2)
                    ->icon('heroicon-o-x-circle'),
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
                ExportBulkAction::make(),
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
            'index' => ListCybersecurities::route('/'),
            'create' => CreateCybersecurity::route('/create'),
            'edit' => EditCybersecurity::route('/{record}/edit'),
        ];
    }
}
