<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Benefit;
use App\Models\Generator;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    public function index()
    {
        return view('admin.Tables.Benefit.benefits', [
            'title' => 'Benefits',
            'benefits' => Benefit::orderBy('name', 'asc')
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

    public function create()
    {
        return view('admin.Tables.Benefit.create', [
            'title' => 'Create Benefit',
            'levels' => Level::orderBy('name', 'asc')
                ->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'levelId' => 'required',
            'description' => 'required|string|max:255',
            'couponCode' => 'required|string|max:10'
        ]);

        Benefit::create([
            'id' => Generator::generateId(Benefit::class),
            'levelId' => $request->levelId,
            'name' => ucwords($request->name),
            'description' => $request->description,
            'couponCode' => strtoupper($request->couponCode),
            'slug' => Generator::generateSlug(Benefit::class, $request->name)
        ]);

        return redirect('/benefits')->with('success', 'Benefit creation successful!');
    }
}
