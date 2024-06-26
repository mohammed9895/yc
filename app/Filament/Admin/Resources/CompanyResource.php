<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CompanyResource\Pages;
use App\Filament\Admin\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use App\Models\Field;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Response;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use ZipArchive;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return   __('companies');
    }

    public static function getModelLabel(): string
    {
        return   __('companies');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('companies');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make(__('filament::company.information'))
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->label(__('Name'))
                                ->reactive()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('cr_number')
                                ->required()
                                ->label(__('cr_number'))
                                ->maxLength(255),
                            Forms\Components\Textarea::make('about')
                                ->label(__('about'))
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('filed')
                                ->label(__('filed'))
                                ->options(Field::where('type', 'freelancer')
                                    ->pluck('name', 'id'))
                                ->required(),
                        ]),
                    Wizard\Step::make(__('companyـowner'))
                        ->schema([
                            Forms\Components\TextInput::make('owner_fullname')
                                ->required()
                                ->label(__('owner_fullname'))
                                ->maxLength(255),
                            Forms\Components\TextInput::make('owner_phone')
                                ->label(__('owner_phone'))
                                ->tel()
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('owner_email')
                                ->email()
                                ->label(__('owner_email'))
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('owner_civil_id')
                                ->required()
                                ->label(__('owner_civil_id'))
                                ->maxLength(255),
                        ]),
                    Wizard\Step::make('Document')
                        ->schema([
                            Forms\Components\FileUpload::make('cr_copy')
                                ->label(__('cr_copy'))
                                ->enableDownload()
                                ->required(),
                            Forms\Components\FileUpload::make('VAT_ceritifcate_copy')->label(__('VAT_ceritifcate_copy'))->enableDownload(),
                            Forms\Components\FileUpload::make('readah_ceritifcate_copy')->label(__('readah_ceritifcate_copy'))->enableDownload(),
                        ]),
                ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->url(fn ($record) => UserResource::getUrl('view', [$record->user_id]))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('name')->label(__('Name'))->searchable(),
                Tables\Columns\TextColumn::make('cr_number')->label(__('cr_number'))->searchable(),
                Tables\Columns\TextColumn::make('about')->label(__('about')),
                Tables\Columns\TextColumn::make('field.name')->label(__('filed'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('owner_fullname')->label(__('owner_fullname'))->searchable(),
                Tables\Columns\TextColumn::make('owner_phone')->label(__('owner_phone'))->searchable(),
                Tables\Columns\TextColumn::make('owner_email')->label(__('owner_email'))->searchable(),
                Tables\Columns\TextColumn::make('owner_civil_id')->label(__('owner_civil_id'))->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('created_at'))
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->label(__('updated_at'))
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('filed')
                ->options(Field::all()->pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('exportAsJson')
                    ->label(__('Download attchments'))
                    ->action(function ($record) {
                        $files = [$record->cr_copy, $record->chamber_ceritifcate_copy, $record->VAT_ceritifcate_copy, $record->readah_ceritifcate_copy];
                        $zip = new ZipArchive();
                        $zip_name = time() . ".zip"; // Zip name
                        $zip->open($zip_name,  ZipArchive::CREATE);
                        foreach ($files as $file) {
                            $path = storage_path('app/public/') . $file;
                            if ($file !== null) {
                                if (file_exists($path) && is_file($path)) {
                                    $zip->addFile($path, $file);
                                } else {
                                    echo "file does not exist";
                                }
                            }
                        }
                        $zip->close();
                        $res = Response::download(public_path($zip_name), $zip_name, array('Content-Type: application/octet-stream', 'Content-Length: ' . filesize($zip_name)))->deleteFileAfterSend(true);
                        return $res;
                    })
                    ->tooltip(__('Download'))
                    ->icon('heroicon-s-download')
                    ->color('primary'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
