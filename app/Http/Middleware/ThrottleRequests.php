<?php

namespace App\Http\Middleware;

use App\Exceptions\AjaxException;
use Closure;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThrottleRequests extends \Illuminate\Routing\Middleware\ThrottleRequests
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param int $maxAttempts
     * @param int $decayMinutes
     * @return ThrottleRequestsException|Response|void
     * @throws AjaxException
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1)
    {
        $key = $this->resolveRequestSignature($request);
        $maxAttempts = $this->resolveMaxAttempts($request, $maxAttempts);
        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return $this->buildException($key, $maxAttempts);
        }
        //去掉 `* 60` 限制秒级,加上去限制分钟,要限制其他单位，可以自己算的
        $this->limiter->hit($key, $decayMinutes);
        //$this->limiter->hit($key, $decayMinutes * 60);

        $response = $next($request);

        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts)
        );
    }

    /**
     * @param Request $key
     * @param string $maxAttempts
     * @return void
     * @throws AjaxException
     */
    protected function buildException($key, $maxAttempts)
    {
        $retryAfter = $this->limiter->availableIn($key);

        throw new AjaxException('您的请求太频繁，已被限制请求');


    }


}
