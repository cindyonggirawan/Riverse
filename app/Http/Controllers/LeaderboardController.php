<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Sukarelawan;
use App\Models\SukarelawanActivityDetail;
use App\Models\SukarelawanActivityStatus;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function processAndShowLeaderboardData() {
        $sukarelawanFromDB = Sukarelawan::all();
        $sukarelawanActivityDetailsFromDB = SukarelawanActivityDetail::where('sukarelawanActivityStatusId', SukarelawanActivityStatus::where('name', 'Claimed')->first()->id)->get();

        if(empty($sukarelawanFromDB) || empty($sukarelawanActivityDetailsFromDB)) {
            return view('public.leaderboard', [
                'title' => 'Empty Leaderboard'
            ]);
        } else {
            $points = array_fill(0, 1000, 0);
            $activityCount = array_fill(0, 1000, 0);
            $sukarelawans = array();

            $idx = 0;

            foreach ($sukarelawanFromDB as $sukarelawan) {
                $sukarelawans[$idx] = $sukarelawan;
                foreach ($sukarelawanActivityDetailsFromDB as $sad) {
                    if ($sukarelawan['id'] == $sad['sukarelawanId']) {
                        $sukarelawanActivities = Activity::where('id', $sad['activityId'])->get();
                        $activityCount[$idx]++;
                        if(!$sukarelawanActivities->isEmpty()) {
                            foreach($sukarelawanActivities as $activity) {
                                $points[$idx] += $activity['experiencePointGiven'];
                            }
                        }
                    }
                }
                $idx++;
            }

            // sort the sukarelawan and points
            for ($i = 0; $i < $idx - 1; $i++) {
                for ($j = 0; $j < $idx - $i - 1; $j++) {
                    if ($points[$j] < $points[$j + 1]) {
                        // swap points
                        $temp = $points[$j];
                        $points[$j] = $points[$j + 1];
                        $points[$j + 1] = $temp;

                        // swap sukarelawan
                        $temp = $sukarelawans[$j];
                        $sukarelawans[$j] = $sukarelawans[$j + 1];
                        $sukarelawans[$j + 1] = $temp;

                        // swap activity count
                        $temp = $activityCount[$j];
                        $activityCount[$j] = $activityCount[$j + 1];
                        $activityCount[$j + 1] = $temp;
                    }
                }
            }

            if (Auth::check() && Auth::user()->role->name == 'Sukarelawan') {
                $userRank = 0;
                $ctr = 0;
                foreach($sukarelawans as $sukarelawan) {
                    $ctr++;
                    if($sukarelawan['id'] == Auth::user()->sukarelawan->id) {
                        $userRank = $ctr;
                    }
                }

                return view('public.leaderboard', [
                    'title' => 'Leaderboard',
                    'activityCount' => $activityCount,
                    'userRank' => $userRank,
                    'userPoints' => $points[$userRank - 1],
                    'userCount' => $ctr,
                    'sortedSukarelawans' => $sukarelawans,
                    'sortedPoints' => $points
                ]);
            } else {
                return view('public.leaderboard', [
                    'title' => 'Leaderboard',
                    'activityCount' => $activityCount,
                    'sortedSukarelawans' => $sukarelawans,
                    'sortedPoints' => $points
                ]);
            }
        }
    }
}
