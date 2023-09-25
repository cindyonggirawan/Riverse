<?php

namespace App\Http\Controllers;

use App\Models\Fasilitator;
use App\Models\Sukarelawan;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function getSukarelawanData()
    {
        if(null !== auth()->user()) {
            $userEmail = auth()->user()->email;

            // Query the 'Sukarelawan' data based on the user's credentials
            $sukarelawanData = Sukarelawan::where('email', $userEmail)->first();

            return $sukarelawanData;
        }
    }

    public function getFasilitatorData()
    {
        if(null !== auth()->user()) {
            $userEmail = auth()->user()->email;

            // Query the 'Fasilitator' data based on the user's credentials
            $fasilitatorData = Fasilitator::where('email', $userEmail)->first();

            return $fasilitatorData;
        }
    }

    public function index() {
        $sukarelawan = $this->getSukarelawanData();
        $fasilitator = $this->getFasilitatorData();

        return view('home', [
            'sukarelawan' => $sukarelawan,
            'fasilitator' => $fasilitator
        ]);
    }


}
