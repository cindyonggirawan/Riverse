<?php

namespace App\Http\Controllers;

use App\Models\Fasilitator;
use Illuminate\Http\Request;
use App\Models\VerificationStatus;

class VerifyFasilitatorController extends Controller
{
    public function indexWaitingForVerificationFasilitator()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id;

        return view('admin.Tables.Fasilitator.waitingForVerification', [
            'title' => 'Waiting For Verification Fasilitators',
            'fasilitators' => Fasilitator::with(['user', 'fasilitatorType'])->where('verificationStatusId', $verificationStatusId)
                ->orderBy('created_at', 'asc')
                ->get()
        ]);
    }

    public function updateVerifiedFasilitator(Fasilitator $fasilitator)
    {
        $fasilitator->update([
            'verificationStatusId' => VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id,
            'verified_at' => now()
        ]);

        return redirect('/waiting-for-verification/fasilitators')->with('success', 'Fasilitator verification successful!');
    }

    public function updateRejectedFasilitator(Request $request, Fasilitator $fasilitator)
    {
        $fasilitator->update([
            'verificationStatusId' => VerificationStatus::where('name', 'Sudah Ditolak')->first()->id,
            'rejected_at' => now(),
            'reasonForRejection' => $request->reasonForRejection !== "" ? $request->reasonForRejection : null
        ]);

        return redirect('/waiting-for-verification/fasilitators')->with('success', 'Fasilitator rejection successful!');
    }

    public function updateAllVerifiedFasilitator()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id;

        $fasilitators = Fasilitator::with(['user', 'fasilitatorType'])->where('verificationStatusId', $verificationStatusId)
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($fasilitators as $fasilitator) {
            $fasilitator->update([
                'verificationStatusId' => VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id,
                'verified_at' => now()
            ]);
        }

        return redirect('/waiting-for-verification/fasilitators')->with('success', 'All Fasilitators verification successful!');
    }

    public function updateAllRejectedFasilitator(Request $request)
    {
        $verificationStatusId = VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id;

        $fasilitators = Fasilitator::with(['user', 'fasilitatorType'])->where('verificationStatusId', $verificationStatusId)
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($fasilitators as $fasilitator) {
            $fasilitator->update([
                'verificationStatusId' => VerificationStatus::where('name', 'Sudah Ditolak')->first()->id,
                'rejected_at' => now(),
                'reasonForRejection' => $request->allReasonForRejection !== "" ? $request->allReasonForRejection : null
            ]);
        }

        return redirect('/waiting-for-verification/fasilitators')->with('success', 'All Fasilitators rejection successful!');
    }

    public function indexVerifiedFasilitator()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id;

        return view('admin.Tables.Fasilitator.verified', [
            'title' => 'Verified Fasilitators',
            'fasilitators' => Fasilitator::with(['user', 'fasilitatorType'])->where('verificationStatusId', $verificationStatusId)
                ->orderBy('verified_at', 'desc')
                ->get()
        ]);
    }

    public function updateUnverifiedFasilitator(Fasilitator $fasilitator)
    {
        $fasilitator->update([
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'verified_at' => null
        ]);

        return redirect('/verified/fasilitators')->with('success', 'Fasilitator unverification successful!');
    }

    public function updateAllUnverifiedFasilitator()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id;

        $fasilitators = Fasilitator::with(['user', 'fasilitatorType'])->where('verificationStatusId', $verificationStatusId)
            ->orderBy('verified_at', 'desc')
            ->get();

        foreach ($fasilitators as $fasilitator) {
            $fasilitator->update([
                'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
                'verified_at' => null
            ]);
        }

        return redirect('/verified/fasilitators')->with('success', 'All Fasilitators unverification successful!');
    }

    public function indexRejectedFasilitator()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Ditolak')->first()->id;

        return view('admin.Tables.Fasilitator.rejected', [
            'title' => 'Rejected Fasilitators',
            'fasilitators' => Fasilitator::with(['user', 'fasilitatorType'])->where('verificationStatusId', $verificationStatusId)
                ->orderBy('rejected_at', 'desc')
                ->get()
        ]);
    }

    public function updateUnrejectedFasilitator(Fasilitator $fasilitator)
    {
        $fasilitator->update([
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'rejected_at' => null,
            'reasonForRejection' => null
        ]);

        return redirect('/rejected/fasilitators')->with('success', 'Fasilitator unrejection successful!');
    }

    public function updateAllUnrejectedFasilitator()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Ditolak')->first()->id;

        $fasilitators = Fasilitator::with(['user', 'fasilitatorType'])->where('verificationStatusId', $verificationStatusId)
            ->orderBy('rejected_at', 'desc')
            ->get();

        foreach ($fasilitators as $fasilitator) {
            $fasilitator->update([
                'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
                'rejected_at' => null,
                'reasonForRejection' => null
            ]);
        }

        return redirect('/rejected/fasilitators')->with('success', 'All Fasilitators unrejection successful!');
    }

    public function indexAllFasilitator()
    {
        return view('admin.Tables.Fasilitator.all', [
            'title' => 'All Fasilitators',
            'fasilitators' => Fasilitator::with(['user', 'verificationStatus', 'fasilitatorType'])
                ->orderBy('created_at', 'asc')
                ->get()
        ]);
    }
}
