<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        $availableLocales = ['en', 'es', 'fr', 'it'];

        if (in_array($locale, $availableLocales)) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }

        // 🔁 Redirige atrás, o al inicio si no hay página anterior
        return redirect()->back() ?? redirect('/');
    }
}
