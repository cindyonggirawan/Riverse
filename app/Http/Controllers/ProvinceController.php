<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        return view('admin.Tables.Province.provinces', [
            'title' => 'Provinces',
            'provinces' => Province::orderBy('id', 'asc')
                ->get()
        ]);
    }

    public function show(Province $province)
    {
        return view('admin.Tables.Province.province', [
            'title' => 'Province',
            'province' => $province
        ]);
    }
}
