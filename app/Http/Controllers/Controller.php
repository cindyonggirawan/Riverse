<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        return view('home', [
            'title' => 'Home',
            'sukarelawan' => $this->getSukarelawan(),
            'fasilitator' => $this->getFasilitator(),
            'admin' => $this->getAdmin(),
        ]);
    }

    private function getSukarelawan()
    {
        if(auth()->user() != null) {
            return auth()->user()->sukarelawan;
        }
    }

    private function getFasilitator()
    {
        if(auth()->user() != null) {
            return auth()->user()->fasilitator;
        }
    }

    private function getAdmin()
    {
        if(auth()->user() != null) {
            return auth()->user();
        }
    }
}
