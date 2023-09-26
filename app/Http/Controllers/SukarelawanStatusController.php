<?php

namespace App\Http\Controllers;

use App\Models\SukarelawanStatus;
use Illuminate\Http\Request;

class SukarelawanStatusController extends Controller
{
    public function index()
    {
        return view('admin.Tables.SukarelawanStatus.sukarelawanStatuses', [
            'title' => 'Sukarelawan Statuses',
            'sukarelawanStatuses' => SukarelawanStatus::orderBy('name', 'asc')
                ->get()
        ]);
    }

    public function show(SukarelawanStatus $sukarelawanStatus)
    {
        return view('admin.Tables.SukarelawanStatus.sukarelawanStatus', [
            'title' => 'Sukarelawan Status',
            'sukarelawanStatus' => $sukarelawanStatus
        ]);
    }
}
