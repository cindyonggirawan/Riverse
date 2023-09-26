<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        return view('admin.Tables.City.cities', [
            'title' => 'Cities',
            'cities' => City::orderBy('id', 'asc')
                ->get()
        ]);
    }

    public function show(City $city)
    {
        return view('admin.Tables.City.city', [
            'title' => 'City',
            'city' => $city
        ]);
    }
}
