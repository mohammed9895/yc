<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Manjam\CategoriesController;
use App\Http\Livewire\Manjam\TalentType;
use App\Jobs\SendMuscatSmsJob;
use App\Notifications\SmsMessage;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use JeffGreco13\FilamentBreezy\Http\Livewire\Auth\ResetPassword;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[HomeController::class, 'index'])->name('home.index');

Route::get('/verify-phone', \App\Livewire\Auth\VerifyPhone::class)->name('verify-phone')->middleware(Authenticate::class);

Route::get('/language/{locale}', function ($locale) {
    Session::put('locale', $locale);
    session()->get('locale');
    return redirect()->back();
})->name('language.switch');

Route::get('/paths/{id}', [HomeController::class, 'path']);

Route::get('/tmakon', [HomeController::class, 'tmakon'])->name('home.tmakon');
Route::get('/incubators', [HomeController::class, 'incubators'])->name('home.incubators');
Route::get('/programs', [HomeController::class, 'programs'])->name('home.programs');

Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');

Route::get('/terms-and-conditions', function () {
    return view('frontend.terms');
})->name('terms-and-conditions');

Route::view('/manjam', 'frontend.manjam');

Route::get('/manjam/talent_type/{talent_type}', \App\Livewire\Manjam\TalentType::class);

// MANJAM
Route::get('/manjam/categories', [CategoriesController::class, 'index'])->name('manjam.all_categories');
Route::get('/manjam/categories/{talent_type}', [CategoriesController::class, 'show']);



Route::get('/admin/run-muscat-sms', function () {

    SendMuscatSmsJob::dispatch();

    return response()->json([
        'status' => 'success',
        'message' => 'Muscat SMS job has been dispatched successfully.'
    ]);

})->middleware(['auth']);
