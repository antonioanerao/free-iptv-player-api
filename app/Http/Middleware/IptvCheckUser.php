<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IptvCheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $data = request()->all();
        $path = env('IPTV_URL').':'.env('IPTV_PORT').'/'.env('IPTV_PLAYER_API').'?username='
            .$data['login'].'&password='.request('password');

        $json = file_get_contents($path);

        $json = json_decode($json, true);

        if($json['user_info']['auth'] == 1){
            if($json['user_info']['status'] == "Active") {
                return $next($request);
            } else {
                return response(["error" => "Account expired"], 401);
            }
        } else {
            return response(["error" => "Invalid account"], 401);
        }
    }
}
