<?php

namespace App\Http\Controllers;

use App\Models\River;
use Illuminate\Http\Request;

class RiverController extends Controller
{
    public function index()
    {
        return view('admin.Tables.River.rivers', [
            'title' => 'Rivers',
            'rivers' => River::orderBy('updated_at', 'desc')
                ->get()
        ]);
    }

    public function show(River $river)
    {
        return view('admin.Tables.River.river', [
            'title' => 'River',
            'river' => $river
        ]);
    }
}
