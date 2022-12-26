<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * xss攻击
 * Class XssMiddleware
 * @package App\Http\Middleware
 */
class XssMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $data = $request->all();
        array_walk_recursive($data, function (&$data) {
            $userInput = strip_tags($data);
        });
        $request->merge($data);
        return $next($request);
    }
}
