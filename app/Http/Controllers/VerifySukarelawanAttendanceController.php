<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Level;
use App\Models\Sukarelawan;
use App\Models\SukarelawanActivityDetail;
use App\Models\SukarelawanActivityStatus;
use App\Models\Fasilitator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifySukarelawanAttendanceController extends Controller
{
    public function indexJoinedSukarelawan(Activity $activity)
    {
        if (Auth::check() && auth()->user()->fasilitator !== null && $activity->fasilitatorId == auth()->user()->fasilitator->id && auth()->user()->fasilitator->verificationStatus->name == 'Sudah Diverifikasi' && $activity->verificationStatus->name == 'Sudah Diverifikasi') {
            return view('public.fasilitator.finalizeAttendance.joinedSukarelawan', [
                'title' => 'Unapproved Joined Sukarelawan',
                'sukarelawanActivityDetails' => SukarelawanActivityDetail::where('sukarelawanActivityStatusId', SukarelawanActivityStatus::where('name', 'Joined')->first()->id)
                    ->where('activityId', $activity->id)
                    ->orderBy('created_at', 'asc')
                    ->get(),
                'activity' => $activity
            ]);
        } else {
            $activities = Activity::latest()->limit(9)->get();
            return view('home', [
                'activities' => $activities,
                'activitiesCount' => Activity::all()->count(),
                'sukarelawanCount' => SukarelawanActivityDetail::all()->count(),
                'fasilitatorCount' => Fasilitator::all()->count(),
            ]);
        }
    }

    public function indexClockedInSukarelawan(Activity $activity)
    {
        if (Auth::check() && auth()->user()->fasilitator !== null && $activity->fasilitatorId == auth()->user()->fasilitator->id && auth()->user()->fasilitator->verificationStatus->name == 'Sudah Diverifikasi' && $activity->verificationStatus->name == 'Sudah Diverifikasi') {
            return view('public.fasilitator.finalizeAttendance.clockedInSukarelawan', [
                'title' => 'Unapproved Clocked In Sukarelawan',
                'sukarelawanActivityDetails' => SukarelawanActivityDetail::where('sukarelawanActivityStatusId', SukarelawanActivityStatus::where('name', 'ClockedIn')->first()->id)
                    ->where('activityId', $activity->id)
                    ->orderBy('created_at', 'asc')
                    ->get(),
                'activity' => $activity
            ]);
        } else {
            $activities = Activity::latest()->limit(9)->get();
            return view('home', [
                'activities' => $activities,
                'activitiesCount' => Activity::all()->count(),
                'sukarelawanCount' => SukarelawanActivityDetail::all()->count(),
                'fasilitatorCount' => Fasilitator::all()->count(),
            ]);
        }
    }

    public function indexClaimedSukarelawan(Activity $activity)
    {
        if (Auth::check() && auth()->user()->fasilitator !== null && $activity->fasilitatorId == auth()->user()->fasilitator->id && auth()->user()->fasilitator->verificationStatus->name == 'Sudah Diverifikasi' && $activity->verificationStatus->name == 'Sudah Diverifikasi') {
            return view('public.fasilitator.finalizeAttendance.claimedSukarelawan', [
                'title' => 'Approved Sukarelawan',
                'sukarelawanActivityDetails' => SukarelawanActivityDetail::where('sukarelawanActivityStatusId', SukarelawanActivityStatus::where('name', 'Claimed')->first()->id)
                    ->where('activityId', $activity->id)
                    ->orderBy('created_at', 'asc')
                    ->get(),
                'activity' => $activity
            ]);
        } else {
            $activities = Activity::latest()->limit(9)->get();
            return view('home', [
                'activities' => $activities,
                'activitiesCount' => Activity::all()->count(),
                'sukarelawanCount' => SukarelawanActivityDetail::all()->count(),
                'fasilitatorCount' => Fasilitator::all()->count(),
            ]);
        }
    }

    public function updateJoinedSukarelawan(Request $request, SukarelawanActivityDetail $sukarelawanActivityDetail)
    {
        $fasilitator = auth()->user()->fasilitator;

        if ($fasilitator) {
            // Change the status from joined to claimed
            $claimedStatus = SukarelawanActivityStatus::where("name", "Claimed")->first();
            $sukarelawanActivityDetail->update([
                'sukarelawanActivityStatusId' => $claimedStatus->id
            ]);

            // Change sukarelawan point and level
            $sukarelawan = $sukarelawanActivityDetail->sukarelawan;

            $allSukarelawanActivityDetail = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawan->id)
                ->where('sukarelawanActivityStatusId', $claimedStatus->id)
                ->get();

            $totalSukarelawanPoints = 0;
            foreach ($allSukarelawanActivityDetail as $sukarelawanActivityDetail) {
                $totalSukarelawanPoints += $sukarelawanActivityDetail->activity->experiencePointGiven;
            }

            $level1 = Level::where('name', 'Level 1')->first();
            $level2 = Level::where('name', 'Level 2')->first();
            $level3 = Level::where('name', 'Level 3')->first();
            $level4 = Level::where('name', 'Level 4')->first();
            $level5 = Level::where('name', 'Level 5')->first();
            $level6 = Level::where('name', 'Level 6')->first();

            if ($totalSukarelawanPoints >= 0 && $totalSukarelawanPoints <= $level1->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level1->id
                ]);
            } else if ($totalSukarelawanPoints > $level1->maximumExperiencePoint && $totalSukarelawanPoints <= $level2->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level2->id
                ]);
            } else if ($totalSukarelawanPoints > $level2->maximumExperiencePoint && $totalSukarelawanPoints <= $level3->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level3->id
                ]);
            } else if ($totalSukarelawanPoints > $level3->maximumExperiencePoint && $totalSukarelawanPoints <= $level4->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level4->id
                ]);
            } else if ($totalSukarelawanPoints > $level4->maximumExperiencePoint && $totalSukarelawanPoints <= $level5->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level5->id
                ]);
            } else if ($totalSukarelawanPoints > $level5->maximumExperiencePoint && $totalSukarelawanPoints <= $level6->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level6->id
                ]);
            }
        } else {
            return redirect('/login');
        }

        return redirect('/' . $request['activitySlug'] . '/waiting-for-verification/joinedSukarelawanAttendance')
            ->with('success', 'Attendance accepted successfully!');
    }

    public function updateClockedInSukarelawan(Request $request, SukarelawanActivityDetail $sukarelawanActivityDetail)
    {
        $fasilitator = auth()->user()->fasilitator;

        if ($fasilitator) {
            // Change the status from clockedin to claimed
            $claimedStatus = SukarelawanActivityStatus::where("name", "Claimed")->first();
            $sukarelawanActivityDetail->update([
                'sukarelawanActivityStatusId' => $claimedStatus->id
            ]);

            // Change sukarelawan point and level
            $sukarelawan = $sukarelawanActivityDetail->sukarelawan;

            $allSukarelawanActivityDetail = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawan->id)
                ->where('sukarelawanActivityStatusId', $claimedStatus->id)
                ->get();

            $totalSukarelawanPoints = 0;
            foreach ($allSukarelawanActivityDetail as $sukarelawanActivityDetail) {
                $totalSukarelawanPoints += $sukarelawanActivityDetail->activity->experiencePointGiven;
            }

            $level1 = Level::where('name', 'Level 1')->first();
            $level2 = Level::where('name', 'Level 2')->first();
            $level3 = Level::where('name', 'Level 3')->first();
            $level4 = Level::where('name', 'Level 4')->first();
            $level5 = Level::where('name', 'Level 5')->first();
            $level6 = Level::where('name', 'Level 6')->first();

            if ($totalSukarelawanPoints >= 0 && $totalSukarelawanPoints <= $level1->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level1->id
                ]);
            } else if ($totalSukarelawanPoints > $level1->maximumExperiencePoint && $totalSukarelawanPoints <= $level2->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level2->id
                ]);
            } else if ($totalSukarelawanPoints > $level2->maximumExperiencePoint && $totalSukarelawanPoints <= $level3->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level3->id
                ]);
            } else if ($totalSukarelawanPoints > $level3->maximumExperiencePoint && $totalSukarelawanPoints <= $level4->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level4->id
                ]);
            } else if ($totalSukarelawanPoints > $level4->maximumExperiencePoint && $totalSukarelawanPoints <= $level5->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level5->id
                ]);
            } else if ($totalSukarelawanPoints > $level5->maximumExperiencePoint && $totalSukarelawanPoints <= $level6->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level6->id
                ]);
            }
        } else {
            return redirect('/login');
        }

        return redirect('/' . $request['activitySlug'] . '/waiting-for-verification/clockedInSukarelawanAttendance')
            ->with('success', 'Attendance accepted successfully!');
    }

    public function updateClaimedSukarelawan(Request $request, SukarelawanActivityDetail $sukarelawanActivityDetail)
    {
        $fasilitator = auth()->user()->fasilitator;

        if ($fasilitator) {
            // Change the status from claimed to joined
            $joinedStatus = SukarelawanActivityStatus::where("name", "Joined")->first();
            $sukarelawanActivityDetail->update([
                'sukarelawanActivityStatusId' => $joinedStatus->id
            ]);

            // Change sukarelawan point and level
            $sukarelawan = $sukarelawanActivityDetail->sukarelawan;

            $claimedStatus = SukarelawanActivityStatus::where("name", "Claimed")->first();
            $allSukarelawanActivityDetail = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawan->id)
                ->where('sukarelawanActivityStatusId', $claimedStatus->id)
                ->get();

            $totalSukarelawanPoints = 0;
            foreach ($allSukarelawanActivityDetail as $sukarelawanActivityDetail) {
                $totalSukarelawanPoints += $sukarelawanActivityDetail->activity->experiencePointGiven;
            }

            $level1 = Level::where('name', 'Level 1')->first();
            $level2 = Level::where('name', 'Level 2')->first();
            $level3 = Level::where('name', 'Level 3')->first();
            $level4 = Level::where('name', 'Level 4')->first();
            $level5 = Level::where('name', 'Level 5')->first();
            $level6 = Level::where('name', 'Level 6')->first();

            if ($totalSukarelawanPoints >= 0 && $totalSukarelawanPoints <= $level1->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level1->id
                ]);
            } else if ($totalSukarelawanPoints > $level1->maximumExperiencePoint && $totalSukarelawanPoints <= $level2->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level2->id
                ]);
            } else if ($totalSukarelawanPoints > $level2->maximumExperiencePoint && $totalSukarelawanPoints <= $level3->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level3->id
                ]);
            } else if ($totalSukarelawanPoints > $level3->maximumExperiencePoint && $totalSukarelawanPoints <= $level4->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level4->id
                ]);
            } else if ($totalSukarelawanPoints > $level4->maximumExperiencePoint && $totalSukarelawanPoints <= $level5->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level5->id
                ]);
            } else if ($totalSukarelawanPoints > $level5->maximumExperiencePoint && $totalSukarelawanPoints <= $level6->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level6->id
                ]);
            }
        } else {
            return redirect('/login');
        }

        return redirect('/' . $request['activitySlug'] . '/verified/claimedSukarelawanAttendance')
            ->with('success', 'Attendance rejected successfully!');
    }
}
