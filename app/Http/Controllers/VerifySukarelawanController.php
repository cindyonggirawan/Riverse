<?php

namespace App\Http\Controllers;

use App\Models\Sukarelawan;
use Illuminate\Http\Request;
use App\Models\VerificationStatus;

class VerifySukarelawanController extends Controller
{
    public function indexWaitingForVerificationSukarelawan()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id;

        return view('admin.Tables.Sukarelawan.waitingForVerification', [
            'title' => 'Waiting For Verification Sukarelawans',
            'sukarelawans' => Sukarelawan::where('verificationStatusId', $verificationStatusId)
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

    public function updateRejectedSukarelawan(Request $request, Sukarelawan $sukarelawan)
    {
        $sukarelawan->update([
            'verificationStatusId' => VerificationStatus::where('name', 'Sudah Ditolak')->first()->id,
            'rejected_at' => now(),
            'reasonForRejection' => $request->reasonForRejection !== "" ? $request->reasonForRejection : null
        ]);

        return redirect('/waiting-for-verification/sukarelawans')->with('success', 'Sukarelawan rejection successful!');
    }

    public function updateAllVerifiedSukarelawan()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id;

        $sukarelawans = Sukarelawan::where('verificationStatusId', $verificationStatusId)
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($sukarelawans as $sukarelawan) {
            $sukarelawan->update([
                'verificationStatusId' => VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id,
                'verified_at' => now()
            ]);
        }

        return redirect('/waiting-for-verification/sukarelawans')->with('success', 'All Sukarelawans verification successful!');
    }

    public function updateAllRejectedSukarelawan(Request $request)
    {
        $verificationStatusId = VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id;

        $sukarelawans = Sukarelawan::where('verificationStatusId', $verificationStatusId)
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($sukarelawans as $sukarelawan) {
            $sukarelawan->update([
                'verificationStatusId' => VerificationStatus::where('name', 'Sudah Ditolak')->first()->id,
                'rejected_at' => now(),
                'reasonForRejection' => $request->allReasonForRejection !== "" ? $request->allReasonForRejection : null
            ]);
        }

        return redirect('/waiting-for-verification/sukarelawans')->with('success', 'All Sukarelawans rejection successful!');
    }

    public function indexVerifiedSukarelawan()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id;

        return view('admin.Tables.Sukarelawan.verified', [
            'title' => 'Verified Sukarelawans',
            'sukarelawans' => Sukarelawan::where('verificationStatusId', $verificationStatusId)
                ->orderBy('verified_at', 'desc')
                ->get()
        ]);
    }

    public function updateUnverifiedSukarelawan(Sukarelawan $sukarelawan)
    {
        $sukarelawan->update([
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'verified_at' => null
        ]);

        return redirect('/verified/sukarelawans')->with('success', 'Sukarelawan unverification successful!');
    }

    public function updateAllUnverifiedSukarelawan()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id;

        $sukarelawans = Sukarelawan::where('verificationStatusId', $verificationStatusId)
            ->orderBy('verified_at', 'desc')
            ->get();

        foreach ($sukarelawans as $sukarelawan) {
            $sukarelawan->update([
                'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
                'verified_at' => null
            ]);
        }

        return redirect('/verified/sukarelawans')->with('success', 'All Sukarelawans unverification successful!');
    }

    public function indexRejectedSukarelawan()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Ditolak')->first()->id;

        return view('admin.Tables.Sukarelawan.rejected', [
            'title' => 'Rejected Sukarelawans',
            'sukarelawans' => Sukarelawan::where('verificationStatusId', $verificationStatusId)
                ->orderBy('rejected_at', 'desc')
                ->get()
        ]);
    }

    public function updateUnrejectedSukarelawan(Sukarelawan $sukarelawan)
    {
        $sukarelawan->update([
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'rejected_at' => null,
            'reasonForRejection' => null
        ]);

        return redirect('/rejected/sukarelawans')->with('success', 'Sukarelawan unrejection successful!');
    }

    public function updateAllUnrejectedSukarelawan()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Ditolak')->first()->id;

        $sukarelawans = Sukarelawan::where('verificationStatusId', $verificationStatusId)
            ->orderBy('rejected_at', 'desc')
            ->get();

        foreach ($sukarelawans as $sukarelawan) {
            $sukarelawan->update([
                'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
                'rejected_at' => null,
                'reasonForRejection' => null
            ]);
        }

        return redirect('/rejected/sukarelawans')->with('success', 'All Sukarelawans unrejection successful!');
    }

    public function indexAllSukarelawan()
    {
        return view('admin.Tables.Sukarelawan.all', [
            'title' => 'All Sukarelawans',
            'sukarelawans' => Sukarelawan::orderBy('created_at', 'asc')
                ->get()
        ]);
    }
}
