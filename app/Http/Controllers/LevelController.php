<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        return view('admin.Tables.Level.levels', [
            'title' => 'Levels',
            'levels' => Level::all()
        ]);
    }

    public function show(Level $level)
    {
        return view('admin.Tables.Level.level', [
            'title' => 'Level',
            'level' => $level
        ]);
    }
}
