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
    public function indexJoinedOrClockedInSukarelawan(Activity $activity)
    {
        if(Auth::check() && auth()->user()->fasilitator !== null && $activity->fasilitatorId == auth()->user()->fasilitator->id) {
            return view('public.fasilitator.finalizeAttendance.joinedOrClockedInSukarelawan', [
                'title' => 'Unapproved Sukarelawan',
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

    public function indexAttendedSukarelawan(Activity $activity)
    {
        if(Auth::check() && auth()->user()->fasilitator !== null && $activity->fasilitatorId == auth()->user()->fasilitator->id) {
            return view('public.fasilitator.finalizeAttendance.attendedSukarelawan', [
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

    public function updateAllClaimedSukarelawan(Request $request) {
        $clockedinStatusId = SukarelawanActivityStatus::where('name', 'Clockedin')->first()->id;

        $clockedinSukarelawanActivityDetails = SukarelawanActivityDetail::where('sukarelawanActivityStatusId', $clockedinStatusId)
            ->where('activityId', $request['activityId'])
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($clockedinSukarelawanActivityDetails as $sukarelawanActivityDetail) {
            $sukarelawanActivityDetail->update([
                'sukarelawanActivityStatusId' => SukarelawanActivityStatus::where('name', 'Claimed')->first()->id
            ]);

            $allSukarelawanActivityDetail = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawanActivityDetail->sukarelawanId)
                ->where('sukarelawanActivityStatusId', SukarelawanActivityStatus::where('name', 'Claimed')->first()->id)
                ->get();

            $totalSukarelawanPoints = 0;
            foreach ($allSukarelawanActivityDetail as $sukarelawanActivityDetail) {
                $totalSukarelawanPoints += $sukarelawanActivityDetail->activity->experiencePointGiven;
            }
            $sukarelawan = Sukarelawan::where('id', $sukarelawanActivityDetail->sukarelawanId)->first();

            $level1 = Level::where('name', 'Level 1')->first();
            $level2 = Level::where('name', 'Level 2')->first();
            $level3 = Level::where('name', 'Level 3')->first();
            $level4 = Level::where('name', 'Level 4')->first();
            $level5 = Level::where('name', 'Level 5')->first();
            $level6 = Level::where('name', 'Level 6')->first();

            if($totalSukarelawanPoints >= 0 && $totalSukarelawanPoints <= $level1->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level1->id
                ]);
            } else if($totalSukarelawanPoints > $level1->maximumExperiencePoint && $totalSukarelawanPoints <= $level2->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level2->id
                ]);
            } else if($totalSukarelawanPoints > $level2->maximumExperiencePoint && $totalSukarelawanPoints <= $level3->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level3->id
                ]);
            } else if($totalSukarelawanPoints > $level3->maximumExperiencePoint && $totalSukarelawanPoints <= $level4->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level4->id
                ]);
            } else if($totalSukarelawanPoints > $level4->maximumExperiencePoint && $totalSukarelawanPoints <= $level5->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level5->id
                ]);
            } else if($totalSukarelawanPoints > $level5->maximumExperiencePoint && $totalSukarelawanPoints <= $level6->maximumExperiencePoint) {
                $sukarelawan->update([
                    'levelId' => $level6->id
                ]);
            }
        }

        return redirect('/' . $request['activitySlug'] . '/waiting-for-verification/attendance')->with('success', 'All Attendance accepted successfully!');
    }

    public function updateAttendedSukarelawan(Request $request, SukarelawanActivityDetail $sukarelawanActivityDetail) {
        $sukarelawanActivityDetail->update([
            'sukarelawanActivityStatusId' => SukarelawanActivityStatus::where('name', 'Claimed')->first()->id
        ]);

        $allSukarelawanActivityDetail = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawanActivityDetail->sukarelawanId)
            ->where('sukarelawanActivityStatusId', SukarelawanActivityStatus::where('name', 'Claimed')->first()->id)
            ->get();

        $totalSukarelawanPoints = 0;
        foreach ($allSukarelawanActivityDetail as $sukarelawanActivityDetail) {
            $totalSukarelawanPoints += $sukarelawanActivityDetail->activity->experiencePointGiven;
        }
        $sukarelawan = Sukarelawan::where('id', $sukarelawanActivityDetail->sukarelawanId)->first();

        $level1 = Level::where('name', 'Level 1')->first();
        $level2 = Level::where('name', 'Level 2')->first();
        $level3 = Level::where('name', 'Level 3')->first();
        $level4 = Level::where('name', 'Level 4')->first();
        $level5 = Level::where('name', 'Level 5')->first();
        $level6 = Level::where('name', 'Level 6')->first();

        if($totalSukarelawanPoints >= 0 && $totalSukarelawanPoints <= $level1->maximumExperiencePoint) {
            $sukarelawan->update([
                'levelId' => $level1->id
            ]);
        } else if($totalSukarelawanPoints > $level1->maximumExperiencePoint && $totalSukarelawanPoints <= $level2->maximumExperiencePoint) {
            $sukarelawan->update([
                'levelId' => $level2->id
            ]);
        } else if($totalSukarelawanPoints > $level2->maximumExperiencePoint && $totalSukarelawanPoints <= $level3->maximumExperiencePoint) {
            $sukarelawan->update([
                'levelId' => $level3->id
            ]);
        } else if($totalSukarelawanPoints > $level3->maximumExperiencePoint && $totalSukarelawanPoints <= $level4->maximumExperiencePoint) {
            $sukarelawan->update([
                'levelId' => $level4->id
            ]);
        } else if($totalSukarelawanPoints > $level4->maximumExperiencePoint && $totalSukarelawanPoints <= $level5->maximumExperiencePoint) {
            $sukarelawan->update([
                'levelId' => $level5->id
            ]);
        } else if($totalSukarelawanPoints > $level5->maximumExperiencePoint && $totalSukarelawanPoints <= $level6->maximumExperiencePoint) {
            $sukarelawan->update([
                'levelId' => $level6->id
            ]);
        }

        return redirect('/' . $request['activitySlug'] . '/waiting-for-verification/attendance')->with('success', 'Attendance accepted successfully!');
    }

    public function updateUnattendedSukarelawan(Request $request, SukarelawanActivityDetail $sukarelawanActivityDetail) {
        $sukarelawanActivityDetail->update([
            'sukarelawanActivityStatusId' => SukarelawanActivityStatus::where('name', 'Terdaftar')->first()->id
        ]);

        $allSukarelawanActivityDetail = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawanActivityDetail->sukarelawanId)
            ->where('sukarelawanActivityStatusId', SukarelawanActivityStatus::where('name', 'Claimed')->first()->id)
            ->get();

        $totalSukarelawanPoints = 0;
        foreach ($allSukarelawanActivityDetail as $sukarelawanActivityDetail) {
            $totalSukarelawanPoints += $sukarelawanActivityDetail->activity->experiencePointGiven;
        }
        $sukarelawan = Sukarelawan::where('id', $sukarelawanActivityDetail->sukarelawanId)->first();

        $level1 = Level::where('name', 'Level 1')->first();
        $level2 = Level::where('name', 'Level 2')->first();
        $level3 = Level::where('name', 'Level 3')->first();
        $level4 = Level::where('name', 'Level 4')->first();
        $level5 = Level::where('name', 'Level 5')->first();
        $level6 = Level::where('name', 'Level 6')->first();

        if($totalSukarelawanPoints >= 0 && $totalSukarelawanPoints <= $level1->maximumExperiencePoint) {
            $sukarelawan->update([
                'levelId' => $level1->id
            ]);
        } else if($totalSukarelawanPoints > $level1->maximumExperiencePoint && $totalSukarelawanPoints <= $level2->maximumExperiencePoint) {
            $sukarelawan->update([
                'levelId' => $level2->id
            ]);
        } else if($totalSukarelawanPoints > $level2->maximumExperiencePoint && $totalSukarelawanPoints <= $level3->maximumExperiencePoint) {
            $sukarelawan->update([
                'levelId' => $level3->id
            ]);
        } else if($totalSukarelawanPoints > $level3->maximumExperiencePoint && $totalSukarelawanPoints <= $level4->maximumExperiencePoint) {
            $sukarelawan->update([
                'levelId' => $level4->id
            ]);
        } else if($totalSukarelawanPoints > $level4->maximumExperiencePoint && $totalSukarelawanPoints <= $level5->maximumExperiencePoint) {
            $sukarelawan->update([
                'levelId' => $level5->id
            ]);
        } else if($totalSukarelawanPoints > $level5->maximumExperiencePoint && $totalSukarelawanPoints <= $level6->maximumExperiencePoint) {
            $sukarelawan->update([
                'levelId' => $level6->id
            ]);
        }

        return redirect('/' . $request['activitySlug'] . '/waiting-for-verification/attendance')->with('success', 'Attendance rejected successfully!');
    }
}
