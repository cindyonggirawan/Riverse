<?php

namespace App\Http\Controllers;

use App\Models\FasilitatorType;
use Illuminate\Http\Request;

class FasilitatorTypeController extends Controller
{
    public function index()
    {
        return view('admin.Tables.FasilitatorType.fasilitatorTypes', [
            'title' => 'Fasilitator Types',
            'fasilitatorTypes' => FasilitatorType::all()
        ]);
    }

    public function show(FasilitatorType $fasilitatorType)
    {
        return view('admin.Tables.FasilitatorType.fasilitatorType', [
            'title' => 'Fasilitator Type',
            'fasilitatorType' => $fasilitatorType
        ]);
    }
}
