<?php

namespace App\Http\Controllers\Public\Dashboard;

use App\Models\CatchCard;
use App\Http\Controllers\Controller;

class CatchCardController extends Controller
{
    public function index()
    {
        $catchCards = CatchCard::with('operator', 'member.user', 'club', 'tournament', 'tournamentTeam', 'boat', 'skipper', 'sponsor', 'fishSpecies')
        ->where('member_id', auth()->user()->member->id)
        ->get();

        return view('public.member_dashboard.catch_card.index', [
            'catchCards' => $catchCards,
        ]);
    }

    public function show(CatchCard $catchCard)
    {
        abort_unless($catchCard->member_id == auth()->user()->member->id, 404);

        return view('public.member_dashboard.catch_card.show', [
            'catchCard'     => $catchCard->load('operator', 'member.user', 'club', 'tournament', 'tournamentTeam', 'boat', 'skipper', 'sponsor', 'fishSpecies'),
            'tagFish'       => $catchCard?->taggedFish,
            'weight_master' => $catchCard?->weightMaster,
        ]);
    }
}
