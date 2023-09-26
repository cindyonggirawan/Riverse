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
            'activities' => Activity::orderBy('updated_at', 'desc')
                ->get()
        ]);
    }

    public function show(Activity $activity)
    {
        return view('admin.Tables.Activity.activity', [
            'title' => 'Activity',
            'activity' => $activity
        ]);
    }

    public function create()
    {
        return view('admin.Tables.Activity.create', [
            'title' => 'Create Activity'
        ]);
    }
}
