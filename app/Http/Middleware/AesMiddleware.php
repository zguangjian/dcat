<?php

namespace App\Http\Middleware;

use App\Exceptions\AjaxException;
use App\Extension\Aes;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * aes 数据加密
 * Class AesMiddleware
 * @package App\Http\Middleware
 */
class AesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     * @throws AjaxException
     */
    public function handle(Request $request, Closure $next)
    {
        $data = $request->all("data");
        if ($data) {
            $data = Aes::decrypt($data);
            if ($data == false) {
                throw new AjaxException("参数错误");
            }
            $request->attributes->add(json_decode($data, true));
        } else {
            throw new AjaxException("参数错误");
        }
        return $next($request);
    }
}
