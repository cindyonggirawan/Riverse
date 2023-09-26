<?php

namespace App\Http\Controllers;

use App\Models\Fasilitator;
use Illuminate\Http\Request;

class FasilitatorController extends Controller
{
    public function index()
    {
        return view('admin.Tables.Fasilitator.fasilitators', [
            'title' => 'Fasilitators',
            'fasilitators' => Fasilitator::orderBy('updated_at', 'desc')
                ->get()
        ]);
    }

    public function show(Fasilitator $fasilitator)
    {
        return view('admin.Tables.Fasilitator.fasilitator', [
            'title' => 'Fasilitator',
            'fasilitator' => $fasilitator
        ]);
    }
}
