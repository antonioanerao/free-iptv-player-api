<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\IptvUser;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function login() {
        $data = request(['login', 'password']);
        $iptvUser = IptvUser::where('login', $data['login'])->where('password', $data['password'])->first();
        $path = env('IPTV_URL').':'.env('IPTV_PORT').'/'.env('IPTV_PLAYER_API').'?username='
            .$data['login'].'&password='.request('password');
        $json = file_get_contents($path);
        $json = json_decode($json, true);

        if(!isset($iptvUser)) {
            if($json['user_info']['auth'] == 1) {
                if($json['user_info']['status'] == "Active") {
                    if($json['user_info']['exp_date'] < Carbon::now()->addHours(3)) {
                        $data['expiration'] = Carbon::now()->addHours(3);
                    }  else {
                        $data['expiration'] = $json['user_info']['exp_date'];
                    }
                    $data['iptvExpiration'] = $json['user_info']['exp_date'];
                    IptvUser::create($data);
                    return response()->json(['sucesso.login'=>'Usuário logado com sucesso']);
                } else {
                    return response()->json(['erro.contaExpirada'=>'A conta expirou']);
                }
            } else {
                return response()->json(['erro.contaInvalida'=>'Conta inválida']);
            }
        } else {
            if($iptvUser->expiration < Carbon::now()) {
                if($json['user_info']['exp_date'] < Carbon::now()->addHours(3)) {
                    $iptvUser->expiration = Carbon::now()->addHours(3);
                }  else {
                    $iptvUser->expiration = $json['user_info']['exp_date'];
                }
                $iptvUser->save();
                return response()->json(['sucesso.sessaoRenovada'=>'Tempo de sessão renovado']);
            } else {
                return response()->json(['sucesso.login'=>'Login efetuado com sucesso']);
            }
        }
    }
}
