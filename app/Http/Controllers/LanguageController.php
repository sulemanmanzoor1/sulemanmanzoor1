<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session as FacadesSession;

class LanguageController extends Controller
{
    public function index($lang)
    {

        if ($lang) {

            App::setLocale($lang);
            $locale = App::currentLocale();
            FacadesSession::put('applocale', $lang);
        }
        return Redirect::back();
    }
}
