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
        if (env("API_AES", false) === true) {
            $data = $request->method() == "POST" ? $request->post("data") : $request->get("data");
            if (!$data) {
                foreach ($request->request as $key => $item) {
                    $request->request->set("$key", "");
                }
            } else {
                $data = Aes::decrypt($data);
                if (!$data) {
                    throw new AjaxException("参数错误");
                }
                $request->request->set("data", null);
                foreach (json_decode($data, true) as $key => $item) {
                    $request->request->set("$key", $item);
                }
            }
        }
        return $next($request);
    }
}
