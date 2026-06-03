<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Referral;

class ReferralHistory extends Component
{
    public $referralId = null;

    protected $listeners = ['listenerReferenceHere'];

    public function render()
    {
        $referrals = Referral::with('client.user')->latest()->get();

        $data = Referral::with('history')->find($this->referralId);

        return view('livewire.referral-history', compact('referrals', 'data'));
    }


    public function listenerReferenceHere($selectedValue)
    { 
        $this->referralId = $selectedValue;
    }
}
