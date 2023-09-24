<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        return view('admin.Tables.Activity.activities', [
            'title' => 'Activities',
            'activities' => Activity::all()
        ]);
    }

    public function show($slug)
    {
        return view('admin.Tables.Activity.activity', [
            'title' => 'Activity',
            'activity' => Activity::find($slug)
        ]);
    }
}
