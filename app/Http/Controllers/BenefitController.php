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
            'couponCode' => 'required|string|max:10',
            'benefitImage_link' => 'nullable|image'
        ]);

        if ($request->hasFile('benefitImage_link')) {
            $validated['benefitImage_link'] = $request->file('benefitImage_link')->store('images', 'public');
        }

        Benefit::create([
            'id' => Generator::generateId(Benefit::class),
            'levelId' => $request->levelId,
            'name' => ucwords($request->name),
            'description' => $request->description,
            'couponCode' => strtoupper($request->couponCode),
            'bannerImageUrl' => $validated['benefitImage_link'],
            'slug' => Generator::generateSlug(Benefit::class, $request->name)
        ]);

        return redirect('/benefits')->with('success', 'Benefit creation successful!');
    }

    public function edit(Benefit $benefit)
    {
        return view('admin.Tables.Benefit.edit', [
            'title' => 'Edit Benefit',
            'benefit' => $benefit,
            'levels' => Level::orderBy('name', 'asc')
                ->get()
        ]);
    }

    public function update(Request $request, Benefit $benefit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'levelId' => 'required',
            'description' => 'required|string|max:255',
            'couponCode' => 'required|string|max:10',
            'benefitImage_link' => 'nullable|image'
        ]);

        $validated['benefitImage_link'] = $benefit->bannerImageUrl;

        if ($request->hasFile('benefitImage_link')) {
            $validated['benefitImage_link'] = $request->file('benefitImage_link')->store('images', 'public');
        }

        $slug = $benefit->slug;

        if ($request->name !== $benefit->name) {
            $slug = Generator::generateSlug(Benefit::class, $request->name);
        }

        $benefit->update([
            'name' => $request->name,
            'levelId' => $request->levelId,
            'description' => $request->description,
            'couponCode' => $request->couponCode,
            'bannerImageUrl' => $validated['benefitImage_link'],
            'slug' => $slug
        ]);

        return redirect('/benefits')->with('success', 'Benefit update successful!');
    }

    public function destroy(Benefit $benefit)
    {
        Benefit::destroy($benefit->id);

        return redirect('/benefits')->with('success', 'Benefit destruction successful!');
    }
}
