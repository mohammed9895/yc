<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Evaluate;
use App\Models\Hall;
use App\Models\Path;
use App\Models\Statistice;
use App\Models\TmakonCategory;
use App\Models\TmakonUser;
use App\Models\Workshop;

class HomeController extends Controller
{
    public function __construct()
    {
        app()->setLocale('ar');
    }

    public function index()
    {
        $paths = Path::all();
        $statistices = Statistice::paginate(4);
        $halls = Hall::paginate(6)->where('status', '1');
        return view('frontend.index', compact('paths', 'statistices', 'halls'));
    }

    public function path($id)
    {
        $path = Path::where('id', $id)->first();
        return view('frontend.paths', compact('id', 'path'));
    }

    public function about()
    {
        $statistices = Statistice::paginate();
        return view('frontend.about', compact('statistices'));
    }

    public function tmakon()
    {
        $tmakonUsers = TmakonUser::paginate(7);
        $tmakonCtegories = TmakonCategory::all();
        return view('frontend.tmakon', compact('tmakonUsers', 'tmakonCtegories'));
    }

    public function incubators()
    {
        return view('frontend.incubators');
    }

    public function programs()
    {

        $evaluates_1 = Evaluate::forPage(1, 10)->where('public', 1)->get();
        $evaluates_2 = Evaluate::where('public', 1)->forPage(2, 10)->get();
        $evaluates_3 = Evaluate::where('public', 1)->forPage(3, 10)->get();

        $upcoming = true;
        $upcoming_programs = Workshop::where('start_date', '>=', now())->get();

        if (count($upcoming_programs) == 0) {
            $upcoming = false;
            $upcoming_programs = Workshop::where('start_date', '<', now())->orderBy('start_date', 'desc')->get();
        }


        return view('frontend.programs', compact('upcoming', 'upcoming_programs', 'evaluates_1', 'evaluates_2', 'evaluates_3'));
    }



    public function contact()
    {
        return view('frontend.contact');
    }
}
