<?php

namespace App\Http\Middleware;

use Closure;
use App\Concerns\LocaleAware;
use Illuminate\Contracts\Translation\HasLocalePreference;

class SetLocale
{
    use LocaleAware;

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($user instanceof HasLocalePreference && !is_null($user->preferredLocale())) {
            app()->setLocale($user->preferredLocale());

            return $next($request);
        }

        app()->setLocale($this->preferredLocale($request));

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function preferredLocale($request): string
    {
        return $request->getPreferredLanguage($this->applicationLocales());
    }
}
