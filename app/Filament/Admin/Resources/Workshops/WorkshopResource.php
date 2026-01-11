<?php

namespace App\Filament\Admin\Resources\Workshops;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Workshops\RelationManagers\SlotsRelationManager;
use App\Filament\Admin\Resources\Workshops\Pages\ListWorkshops;
use App\Filament\Admin\Resources\Workshops\Pages\CreateWorkshop;
use App\Filament\Admin\Resources\Workshops\Pages\EditWorkshop;
use App\Filament\Admin\Resources\Workshops\Pages\ViewUser;
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
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class WorkshopResource extends Resource
{

    protected static ?string $model = Workshop::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('workshops');
    }

    public static function getPluralModelLabel(): string
    {
        return __('workshops');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Tabs::make('Heading')
                            ->tabs([
                                Tab::make(__('english'))
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
                                Tab::make(__('arabic'))
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
                Group::make()
                    ->schema([
                        Section::make(__('Main Info'))
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
                        Section::make(__('Questions'))
                            ->schema([
                                Toggle::make('has_questions')->label(__('has_questions')),
                                Tabs::make('Heading')
                                    ->tabs([
                                        Tab::make(__('english'))
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
                                        Tab::make(__('arabic'))
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
                TextColumn::make('title')->label(__('title')),
                TextColumn::make('user.name')->label(__('instructor')),
                // Tables\Columns\TextColumn::make('description'),
                TextColumn::make('capacity')->label(__('capacity')),
                TextColumn::make('conditions')->label(__('conditions')),
                TextColumn::make('place.name')->label(__('place')),
                ImageColumn::make('cover')->size(100)->label(__('cover')),
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SlotsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkshops::route('/'),
            'create' => CreateWorkshop::route('/create'),
            'edit' => EditWorkshop::route('/{record}/edit'),
            'view' => ViewUser::route('/{record}'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('workshops');
    }
}
