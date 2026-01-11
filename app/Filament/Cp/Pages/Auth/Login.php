<?php

namespace App\Filament\Cp\Pages\Auth;

use Filament\Schemas\Schema;


class Login extends \Filament\Auth\Pages\Login
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected string $view = 'filament.cp.pages.auth.login';
    protected static string $layout = 'layouts.auth';

    public ?array $data = [];

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
