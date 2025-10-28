<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetLang
{

    public function handle(Request $request, Closure $next): Response
    {

        if (session()->has('locale'))
        {
            App::setLocale(session('locale'));
        }
        return $next($request);
    }
}
