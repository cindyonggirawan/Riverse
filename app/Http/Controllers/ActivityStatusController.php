<?php

namespace App\Http\Controllers;

use App\Models\ActivityStatus;
use Illuminate\Http\Request;

class ActivityStatusController extends Controller
{
    public function index()
    {
        return view('admin.Tables.ActivityStatus.activityStatuses', [
            'title' => 'Activity Statuses',
            'activityStatuses' => ActivityStatus::all()
        ]);
    }

    public function show(ActivityStatus $activityStatus)
    {
        return view('admin.Tables.ActivityStatus.activityStatus', [
            'title' => 'Activity Status',
            'activityStatus' => $activityStatus
        ]);
    }
}
