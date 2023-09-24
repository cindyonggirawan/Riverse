<?php

namespace App\Http\Controllers;

use App\Models\Sukarelawan;
use Illuminate\Http\Request;

class SukarelawanController extends Controller
{
    public function index()
    {
        return view('admin.Tables.Sukarelawan.sukarelawans', [
            'title' => 'Sukarelawans',
            'sukarelawans' => Sukarelawan::all()
        ]);
    }

    public function show(Sukarelawan $sukarelawan)
    {
        return view('admin.Tables.Sukarelawan.sukarelawan', [
            'title' => 'Sukarelawan',
            'sukarelawan' => $sukarelawan
        ]);
    }
}
