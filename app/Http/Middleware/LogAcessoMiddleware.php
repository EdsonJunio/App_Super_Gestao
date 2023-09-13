<?php

namespace App\Http\Middleware;

use Closure;
use App\LogAcesso;
use http\Env\Response;

class LogAcessoMiddleware
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
        // request - manipular
        //return $next($request);

        $ip = $request->server->get('REMOTE_ADDR');
        $rota = $request->getRequestUri();
        LogAcesso::create(['log' => "IP $ip requestou a rota $rota "]);
       return Response('Chegamos no midleware e finalizamos no próprio middleware');
    }
}
