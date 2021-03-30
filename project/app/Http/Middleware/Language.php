<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $storeval = $request->segment(1);

        if($storeval == 'admin')
        {
            $locale = get_defaultlanguage();
        }
        else
        {
            if(Session::has('locale'))
            {
                $locale = Session::get('locale', Config::get('app.locale'));
            }
            else
            {
                $locale = get_defaultlanguage();
            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}
