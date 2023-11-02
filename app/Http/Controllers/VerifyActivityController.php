<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\VerificationStatus;
use Illuminate\Support\Facades\Storage;

class VerifyActivityController extends Controller
{
    public function indexWaitingForVerificationActivity()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id;

        return view('admin.Tables.Activity.waitingForVerification', [
            'title' => 'Waiting For Verification Activities',
            'activities' => Activity::where('verificationStatusId', $verificationStatusId)
                ->orderBy('created_at', 'asc')
                ->get()
        ]);
    }

    public function updateVerifiedActivity(Request $request, Activity $activity)
    {
        $activity->update([
            'experiencePointGiven' => $request->experiencePointGiven,
            'verificationStatusId' => VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id,
            'verified_at' => now()
        ]);

        return redirect('/waiting-for-verification/activities')->with('success', 'Activity verification successful!');
    }

    public function updateRejectedActivity(Request $request, Activity $activity)
    {
        $activity->update([
            'verificationStatusId' => VerificationStatus::where('name', 'Sudah Ditolak')->first()->id,
            'rejected_at' => now(),
            'reasonForRejection' => $request->reasonForRejection !== "" ? $request->reasonForRejection : null
        ]);

        return redirect('/waiting-for-verification/activities')->with('success', 'Activity rejection successful!');
    }

    public function updateAllVerifiedActivity(Request $request)
    {
        $verificationStatusId = VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id;

        $activities = Activity::where('verificationStatusId', $verificationStatusId)
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($activities as $activity) {
            $activity->update([
                'experiencePointGiven' => $request->allExperiencePointGiven,
                'verificationStatusId' => VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id,
                'verified_at' => now()
            ]);
        }

        return redirect('/waiting-for-verification/activities')->with('success', 'All Activities verification successful!');
    }

    public function updateAllRejectedActivity(Request $request)
    {
        $verificationStatusId = VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id;

        $activities = Activity::where('verificationStatusId', $verificationStatusId)
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($activities as $activity) {
            $activity->update([
                'verificationStatusId' => VerificationStatus::where('name', 'Sudah Ditolak')->first()->id,
                'rejected_at' => now(),
                'reasonForRejection' => $request->allReasonForRejection !== "" ? $request->allReasonForRejection : null
            ]);
        }

        return redirect('/waiting-for-verification/activities')->with('success', 'All Activities rejection successful!');
    }

    public function indexVerifiedActivity()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id;

        return view('admin.Tables.Activity.verified', [
            'title' => 'Verified Activities',
            'activities' => Activity::where('verificationStatusId', $verificationStatusId)
                ->orderBy('verified_at', 'desc')
                ->get()
        ]);
    }

    public function updateUnverifiedActivity(Activity $activity)
    {
        $activity->update([
            'experiencePointGiven' => 0,
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'verified_at' => null
        ]);

        return redirect('/verified/activities')->with('success', 'Activity unverification successful!');
    }

    public function updateAllUnverifiedActivity()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id;

        $activities = Activity::where('verificationStatusId', $verificationStatusId)
            ->orderBy('verified_at', 'desc')
            ->get();

        foreach ($activities as $activity) {
            $activity->update([
                'experiencePointGiven' => 0,
                'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
                'verified_at' => null
            ]);
        }

        return redirect('/verified/activities')->with('success', 'All Activities unverification successful!');
    }

    public function indexRejectedActivity()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Ditolak')->first()->id;

        return view('admin.Tables.Activity.rejected', [
            'title' => 'Rejected Activities',
            'activities' => Activity::where('verificationStatusId', $verificationStatusId)
                ->orderBy('rejected_at', 'desc')
                ->get()
        ]);
    }

    public function updateUnrejectedActivity(Activity $activity)
    {
        $activity->update([
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'rejected_at' => null,
            'reasonForRejection' => null
        ]);

        return redirect('/rejected/activities')->with('success', 'Activity unrejection successful!');
    }

    public function updateAllUnrejectedActivity()
    {
        $verificationStatusId = VerificationStatus::where('name', 'Sudah Ditolak')->first()->id;

        $activities = Activity::where('verificationStatusId', $verificationStatusId)
            ->orderBy('rejected_at', 'desc')
            ->get();

        foreach ($activities as $activity) {
            $activity->update([
                'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
                'rejected_at' => null,
                'reasonForRejection' => null
            ]);
        }

        return redirect('/rejected/activities')->with('success', 'All Activities unrejection successful!');
    }

    public function indexAllActivity()
    {
        return view('admin.Tables.Activity.all', [
            'title' => 'All Activities',
            'activities' => Activity::orderBy('created_at', 'asc')
                ->get()
        ]);
    }

    public function destroyAllActivity()
    {
        $activities = Activity::orderBy('created_at', 'asc')
            ->get();

        foreach ($activities as $activity) {
            if ($activity->bannerImageUrl) {
                Storage::delete($activity->bannerImageUrl);
            }
            $activity->delete();
        }

        return redirect('/all/activities')->with('success', 'All Activities destruction successful!');
    }
}
