<?php
/**
 * Created by PhpStorm.
 * User: THUY-KIM
 * Date: 7/24/2017
 * Time: 4:52 PM
 */

namespace App\Http\Middleware;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Locale
{
    public static function handle($request, $next)
    {
        if (!Session::has('locale')) {

            App::setLocale('locale',1);
        }
        else{
            App::setLocale('locale',Session::get('locale'));
        }
        return $next($request);

    }
}