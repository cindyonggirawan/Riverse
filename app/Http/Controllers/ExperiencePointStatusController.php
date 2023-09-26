<?php

namespace App\Http\Controllers;

use App\Models\ExperiencePointStatus;
use Illuminate\Http\Request;

class ExperiencePointStatusController extends Controller
{
    public function index()
    {
        return view('admin.Tables.ExperiencePointStatus.experiencePointStatuses', [
            'title' => 'Experience Point Statuses',
            'experiencePointStatuses' => ExperiencePointStatus::orderBy('name', 'asc')
                ->get()
        ]);
    }

    public function show(ExperiencePointStatus $experiencePointStatus)
    {
        return view('admin.Tables.ExperiencePointStatus.experiencePointStatus', [
            'title' => 'Experience Point Status',
            'experiencePointStatus' => $experiencePointStatus
        ]);
    }
}
