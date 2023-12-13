<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Generator;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function publicIndex()
    {
        return view('public.benefits', [
            'title' => 'Levels',
            'levels' => Level::orderBy('name', 'asc')
                ->get()
        ]);
    }
}
