<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Generator;
use App\Models\Level;

use App\Models\Sukarelawan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\VerificationStatus;
use Illuminate\Support\Facades\Storage;

class SukarelawanController extends Controller
{
    public function publicShow(Sukarelawan $sukarelawan)
    {
        $levels = Level::orderBy("name")->get();

        $clockedInActivityCount = 0;
        $terdaftarActivityCount = 0;
        $claimedActivityCount = 0;
        $points = 0;
        $nextLevel = null;


        $sActivityDetail = $sukarelawan->sukarelawan_activity_details;

        if ($sActivityDetail) {
            for ($i = 0; $i < $sActivityDetail->count(); $i++) {
                if ($sActivityDetail[$i]->sukarelawanActivityStatus->name == 'Claimed') {
                    $activityPoint = $sActivityDetail[$i]->activity->experiencePointGiven;
                    $points += $activityPoint;
                    $claimedActivityCount++;
                } elseif ($sActivityDetail[$i]->sukarelawanActivityStatus->name == 'ClockedIn') {
                    $clockedInActivityCount++;
                } elseif ($sActivityDetail[$i]->sukarelawanActivityStatus->name == 'Terdaftar'){
                    $terdaftarActivityCount++;
                }
            }
        }

        return view('public.sukarelawan.profile', [
            'title' => 'Sukarelawan',
            'sukarelawan' => $sukarelawan,
            'levels' => $levels,
            'clockedInActivityCount' => $clockedInActivityCount,
            'terdaftarActivityCount' => $terdaftarActivityCount,
            'claimedActivityCount' => $claimedActivityCount,
            'points' => $points,
            'nextLevel' => $nextLevel,
            'sActivityDetail' => $sActivityDetail
        ]);
    }

    public function manage(Sukarelawan $sukarelawan){
        $activityDetails = $sukarelawan->sukarelawan_activity_details()->orderBy('updated_at', 'desc')->get();

        return view('public.sukarelawan.manage', [
            'title' => 'Sukarelawan',
            'sukarelawan' => $sukarelawan,
            'activityDetails' => $activityDetails
        ]);
    }

    public function publicEdit(Sukarelawan $sukarelawan)
    {
        return view('public.sukarelawan.edit', [
            'title' => 'Edit Sukarelawan',
            'sukarelawan' => $sukarelawan,
            'verificationStatuses' => VerificationStatus::orderBy('name', 'asc')
            ->get()
        ]);
    }

    public function publicUpdate(Request $request, Sukarelawan $sukarelawan){
        $validated = $request->validate([
            'email' => [
                'required',
                'max:255',
                'email:dns',
                'regex:/^\S+@\S+\.\S+$/',
                Rule::unique('users')->ignore($sukarelawan->id),
            ],
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'dateOfBirth' => 'required|date',
            'gender' => 'required',
            ]);

            $slug = $sukarelawan->slug;
            if ($request->name !== $sukarelawan->user->name) {
                $slug = Generator::generateSlug(User::class, $request->name);
            }

            $user = $sukarelawan->user;
            $user->update([
                    'email' => strtolower($request->email),
                    'name' => ucwords($request->name),
                    'slug' => $slug
                ]);
            $sukarelawan->update([
                'gender' => $request->gender,
                'dateOfBirth' => date('Y-m-d', strtotime(str_replace('/', '-', $request->dateOfBirth))),
                'slug' => $slug
            ]);

            if ($request->picture && $request->picture != "") {
                $request->validate(['picture'=> 'image']);
                $newProfPicFile = $request->file('picture');
                if ($sukarelawan->profileImageUrl && $sukarelawan->profileImageUrl != '') {
                    Storage::delete($sukarelawan->profileImageUrl);
                }
                $newProfPicName = $sukarelawan->id . '.' . $newProfPicFile->getClientOriginalExtension();
                $profileImageUrl = $newProfPicFile->storeAs('/public/images/Sukarelawan/profileImages', $newProfPicName);
                $profileImageUrl = 'Sukarelawan/profileImages/' . $newProfPicName;

                $sukarelawan->update([
                    'profileImageUrl' => $profileImageUrl,
                ]);
            }

        return redirect('/sukarelawans' . '/' . $sukarelawan->slug)->with('success', 'Sukarelawan update successful!');
    }

}
