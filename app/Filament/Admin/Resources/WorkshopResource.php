<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\WorkshopResource\Pages;
use App\Filament\Admin\Resources\WorkshopResource\RelationManagers;
use App\Models\Hall;
use App\Models\Path;
use App\Models\Place;
use App\Models\State;
use App\Models\User;
use App\Models\Workshop;
use Filament\Forms;
use Filament\Forms\Components\Builder as FilamentBuilder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class WorkshopResource extends Resource
{

    protected static ?string $model = Workshop::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('workshops');
    }

    public static function getPluralModelLabel(): string
    {
        return __('workshops');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Tabs::make('Heading')
                            ->tabs([
                                Tabs\Tab::make(__('english'))
                                    ->icon('heroicon-o-information-circle')
                                    ->schema([
                                        TextInput::make('title_en')
                                            ->label(__('title_en'))
                                            ->reactive()
                                            ->afterStateUpdated(fn($state, callable $set) => $set('slug',
                                                Str::slug($state))),
                                        MarkdownEditor::make('description_en')->label(__('description_en')),
                                        TagsInput::make('conditions_en')->placeholder('add condition')->label(__('conditions_en')),
                                        FileUpload::make('cover_en')->label(__('cover_en')),
                                        Toggle::make('status')->label(__('status')),
                                    ]),
                                Tabs\Tab::make(__('arabic'))
                                    ->icon('heroicon-o-information-circle')
                                    ->schema([
                                        TextInput::make('title_ar')->label(__('title_ar')),
                                        MarkdownEditor::make('description_ar')->label(__('description_ar')),
                                        TagsInput::make('conditions_ar')->placeholder('add condition')->label(__('conditions_ar')),
                                        FileUpload::make('cover_ar')->label(__('cover_ar')),
                                    ]),
                            ]),
                    ])
                    ->columns(1),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('Main Info'))
                            ->schema([
                                TextInput::make('slug')->label(__('slug')),
                                TextInput::make('capacity')->numeric()->label(__('capacity')),
                                TextInput::make('days')->required()->numeric()->label(__('Days')),
                                Select::make('place_id')->options(Place::all()->pluck('name',
                                    'id'))->searchable()->label(__('place')),
                                Select::make('place_id')->options(State::all()->pluck('name',
                                    'id'))->searchable()->label(__('state')),
                                Select::make('path_id')->options(Path::all()->pluck('name',
                                    'id'))->searchable()->label(__('path')),
                                Select::make('hall_id')->options(Hall::all()->pluck('name',
                                    'id'))->searchable()->label(__('hall')),
                                Select::make('user_id')->options(User::role('instructor')->pluck('name',
                                    'id'))->searchable()->label(__('instructor')),
                            ])
                            ->columnSpan(['lg' => 1]),
                        Forms\Components\Section::make(__('Questions'))
                            ->schema([
                                Toggle::make('has_questions')->label(__('has_questions')),
                                Tabs::make('Heading')
                                    ->tabs([
                                        Tabs\Tab::make(__('english'))
                                            ->icon('heroicon-o-information-circle')
                                            ->schema([
                                                FilamentBuilder::make('question_en')
                                                    ->label(__('question_en'))
                                                    ->blocks([
                                                        FilamentBuilder\Block::make('open_question')
                                                            ->label(__('open_question'))
                                                            ->schema([
                                                                TextInput::make('open_question')
                                                                    ->label(__('Open Question Label'))
                                                            ]),
                                                        FilamentBuilder\Block::make('checkbox_question')
                                                            ->label(__('checkbox_question'))
                                                            ->schema([
                                                                TextInput::make('checkbox_question')
                                                                    ->label(__('Chechbox Label'))

                                                            ]),
                                                        FilamentBuilder\Block::make('upload_question')
                                                            ->label(__('upload_question'))
                                                            ->schema([
                                                                TextInput::make('file_question')
                                                                    ->label(__('Upload File Label'))

                                                            ]),

                                                        FilamentBuilder\Block::make('options_question')
                                                            ->label(__('options_question'))
                                                            ->schema([
                                                                TextInput::make('options_question')
                                                                    ->label(__('Options Label')),
                                                                TagsInput::make('options_list')->label('Options List')->separator(','),
                                                            ]),
                                                    ])
                                            ]),
                                        Tabs\Tab::make(__('arabic'))
                                            ->icon('heroicon-o-information-circle')
                                            ->schema([
                                                FilamentBuilder::make('question_ar')
                                                    ->label(__('question_ar'))
                                                    ->blocks([
                                                        FilamentBuilder\Block::make('open_question')
                                                            ->label(__('open_question'))
                                                            ->schema([
                                                                TextInput::make('open_question')
                                                                    ->label(__('Open Question Label'))

                                                            ]),
                                                        FilamentBuilder\Block::make('checkbox_question')
                                                            ->label(__('checkbox_question'))
                                                            ->schema([
                                                                TextInput::make('checkbox_question')
                                                                    ->label(__('Chechbox Label'))
                                                            ]),
                                                        FilamentBuilder\Block::make('upload_question')
                                                            ->label(__('upload_question'))
                                                            ->schema([
                                                                TextInput::make('file_question')
                                                                    ->label(__('Upload File Label'))

                                                            ]),

                                                        FilamentBuilder\Block::make('options_question')
                                                            ->label(__('options_question'))
                                                            ->schema([
                                                                TextInput::make('options_question')->label(__('Options Label')),
                                                                TagsInput::make('options_list')->label(__('Options List'))->separator(','),
                                                            ]),
                                                    ])
                                            ]),
                                    ]),
                            ])
                            ->columnSpan(['lg' => 1]),
                    ])->columns(1),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label(__('title')),
                Tables\Columns\TextColumn::make('user.name')->label(__('instructor')),
                // Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('capacity')->label(__('capacity')),
                Tables\Columns\TextColumn::make('conditions')->label(__('conditions')),
                Tables\Columns\TextColumn::make('place.name')->label(__('place')),
                Tables\Columns\ImageColumn::make('cover')->size(100)->label(__('cover')),
            ])
            ->filters([
                SelectFilter::make('path_id')
                    ->multiple()
                    ->label(__('path'))
                    ->options(Path::all()->pluck('name', 'id')),
                SelectFilter::make('hall_id')
                    ->multiple()
                    ->label(__('hall'))
                    ->options(Hall::all()->pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SlotsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkshops::route('/'),
            'create' => Pages\CreateWorkshop::route('/create'),
            'edit' => Pages\EditWorkshop::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('workshops');
    }
}
