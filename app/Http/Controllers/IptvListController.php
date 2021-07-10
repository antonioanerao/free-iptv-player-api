<?php

namespace App\Http\Controllers;

use App\Models\IptvList;

/**
 * @property IptvList iptvList
 */
class IptvListController extends Controller
{
    public function __construct(IptvList $iptvList) {
        $this->middleware('IptvCheckUser');
        $this->iptvList = $iptvList;
    }

    public function liveTvGroups() {
        $channels = $this->iptvList->where('maingroup', 'live')
            ->select('tvgroup')
            ->distinct()
            ->get();

        return response()->json(['liveTvGroups'=>$channels]);
    }

    public function liveTvChannels() {
        $channels = $this->iptvList->where('tvgroup', request()->input('tvGroup'))
            ->distinct()
            ->get();

        if($channels->count() > 0) {
            return response()->json($channels, 200);
        } else {
            return response()->json(['erro.liveTvChannels'=>'Nenhum canal encontrado neste grupo']);
        }
    }
}
