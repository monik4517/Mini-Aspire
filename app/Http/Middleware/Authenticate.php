<?php

namespace App\Http\Middleware;

use App\Http\Resources\DataFalseResource;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Exception;

class Authenticate extends Middleware
{

    /**
     * @var array
     */
    protected $guards = [];

    /**
     *  Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param string[] ...$guards
     * @return \Illuminate\Http\Response|mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;
        try {
            $this->authenticate($request, $guards);
            return parent::handle($request, $next, ...$guards);
        }  catch (Exception $e) {
            return new DataFalseResource(trans('messages.auth.token_not_found'),config('constants.validation_codes.unauthorized'));
        }
    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return '';
        }
    }
}
