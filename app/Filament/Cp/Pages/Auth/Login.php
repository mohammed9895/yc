<?php

namespace App\Filament\Cp\Pages\Auth;

use Filament\Pages\Page;
use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.cp.pages.auth.login';
}
