<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    public function index()
    {
        return view('admin.Tables.Benefit.benefits', [
            'title' => 'Benefits',
            'benefits' => Benefit::with(['level'])
                ->orderBy('name', 'asc')
                ->get()
        ]);
    }

    public function show(Benefit $benefit)
    {
        return view('admin.Tables.Benefit.benefit', [
            'title' => 'Level',
            'benefit' => $benefit
        ]);
    }
}
