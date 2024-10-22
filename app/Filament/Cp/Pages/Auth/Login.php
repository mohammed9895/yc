<?php

namespace App\Filament\Cp\Pages\Auth;

use Filament\Pages\Auth\Login as BaseAuth;
use Filament\Forms\Form;

class Login extends BaseAuth
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.cp.pages.auth.login';
    protected static string $layout = 'layouts.auth';

    public ?array $data = [];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }


//    public function login()
//    {
//       $this->authenticate();
//    }
}
