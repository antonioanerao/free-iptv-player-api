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

    public function moviesGroups() {
        $moviesGroups = $this->iptvList->where('maingroup', 'movie')
            ->select('tvgroup')
            ->groupBy('tvgroup')
            ->get();

        return response()->json(['moviesGroups'=>$moviesGroups]);
    }

    public function moviesChannels() {
        $movies = $this->iptvList->where('tvgroup', request()->input('tvGroup'))
            ->distinct()
            ->get();

        if($movies->count() > 0) {
            return response()->json($movies, 200);
        } else {
            return response()->json(['erro.moviesChannels'=>'Nenhum filme encontrado neste grupo']);
        }
    }

    public function seriesGroups() {
        $seriesGroups = $this->iptvList->where('maingroup', 'series')
            ->select('tvgroup')
            ->groupBy('tvgroup')
            ->get();

        return response()->json(['seriesGroups'=>$seriesGroups]);
    }

    public function seriesChannels() {
        $series = $this->iptvList->where('tvgroup', request()->input('tvGroup'))
            ->distinct()
            ->get();

        if($series->count() > 0) {
            return response()->json($series, 200);
        } else {
            return response()->json(['erro.seriesChannels'=>'Nenhuma serie encontrado neste grupo']);
        }
    }
}
