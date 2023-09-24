<?php

namespace App\Http\Controllers;

use App\Models\VerificationStatus;
use Illuminate\Http\Request;

class VerificationStatusController extends Controller
{
    public function index()
    {
        return view('admin.Tables.VerificationStatus.verificationStatuses', [
            'title' => 'Verification Statuses',
            'verificationStatuses' => VerificationStatus::all()
        ]);
    }

    public function show(VerificationStatus $verificationStatus)
    {
        return view('admin.Tables.VerificationStatus.verificationStatus', [
            'title' => 'Verification Status',
            'verificationStatus' => $verificationStatus
        ]);
    }
}
