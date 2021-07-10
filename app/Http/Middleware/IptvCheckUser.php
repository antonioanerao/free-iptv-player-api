<?php

namespace App\Http\Middleware;

use App\Models\IptvUser;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class IptvCheckUser
{
    /**
     * Checa se o usuário informado é válido e não está expirado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $data = request(['login', 'password']);
        if(!empty($data['login']) && !empty($data['password'])) {
            $iptvUser = IptvUser::where('login', $data['login'])->where('password', $data['password'])->first();

            if(isset($iptvUser)) {
                if($iptvUser->expiration > Carbon::now()) {
                    return $next($request);
                } else {
                    return response()->json(['error.sessaoExpirada'=>'Seu tempo de sessão expirou']);
                }
            } else {
                return response()->json(['error.fazerLogin'=>'Faça o login para continuar']);
            }
        } else {
            return response()->json(['erro.informeLogin'=>'Informe os campos login e password']);
        }

    }
}
