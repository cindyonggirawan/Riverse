<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Generator;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        return view('admin.Tables.Level.levels', [
            'title' => 'Levels',
            'levels' => Level::orderBy('name', 'asc')
                ->get()
        ]);
    }

    public function show(Level $level)
    {
        return view('admin.Tables.Level.level', [
            'title' => 'Level',
            'level' => $level
        ]);
    }

    public function create()
    {
        return view('admin.Tables.Level.create', [
            'title' => 'Create Level'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'maximumExperiencePoint' => 'required|integer|min:1|max:999'
        ]);

        Level::create([
            'id' => Generator::generateId(Level::class),
            'name' => ucwords($request->name),
            'maximumExperiencePoint' => $request->maximumExperiencePoint,
            'slug' => Generator::generateSlug(Level::class, $request->name)
        ]);

        return redirect('/levels')->with('success', 'Level creation successful!');
    }
}
