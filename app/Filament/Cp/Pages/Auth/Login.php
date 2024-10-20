<?php

namespace App\Filament\Cp\Pages\Auth;

use Filament\Pages\Auth\Login as BaseAuth;

class Login extends BaseAuth
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.cp.pages.auth.login';
    protected static string $layout = 'layouts.auth';
}
