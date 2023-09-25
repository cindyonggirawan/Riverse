<?php

namespace App\Http\Controllers;

use App\Models\Sukarelawan;
use App\Models\VerificationStatus;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function indexSukarelawan()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id;

        return view('admin.Tables.Sukarelawan.waitingForVerification', [
            'title' => 'Waiting For Verification',
            'sukarelawans' => Sukarelawan::with(['user'])->where('verificationStatusId', $verificationStatusId)
                ->orderBy('created_at', 'asc')
                ->get()
        ]);
    }

    public function updateVerifiedSukarelawan(Sukarelawan $sukarelawan)
    {
        $sukarelawan->update([
            'verificationStatusId' => VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id,
            'verified_at' => now()
        ]);

        return redirect('/waiting-for-verification/sukarelawans')->with('success', 'Sukarelawan verification successful!');
    }

    public function updateRejectedSukarelawan(Sukarelawan $sukarelawan)
    {
        $sukarelawan->update([
            'verificationStatusId' => VerificationStatus::where('name', 'Sudah Ditolak')->first()->id,
            'rejected_at' => now()
        ]);

        return redirect('/waiting-for-verification/sukarelawans')->with('success', 'Sukarelawan rejection successful!');
    }
}
