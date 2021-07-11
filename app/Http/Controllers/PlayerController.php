<?php

namespace App\Http\Controllers;

use App\Models\IptvList;

class PlayerController extends Controller
{
    public function __construct(IptvList $iptvList) {
        $this->middleware('IptvCheckUser');
        $this->iptvList = $iptvList;
    }

    public function player() {
        if(empty(request('id'))) {
            return response()->json(['erro.idVazio'=>'Informe o ID do canal, filme ou serie']);
        }
        $video = IptvList::where('id', '=', request('id'))->first();
        return response()->json($video);
    }
}
