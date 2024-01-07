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
        $joinedActivityCount = 0;
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
                } elseif ($sActivityDetail[$i]->sukarelawanActivityStatus->name == 'Joined') {
                    $joinedActivityCount++;
                }
            }
        }

        return view('public.sukarelawan.profile', [
            'title' => 'Sukarelawan',
            'sukarelawan' => $sukarelawan,
            'levels' => $levels,
            'clockedInActivityCount' => $clockedInActivityCount,
            'joinedActivityCount' => $joinedActivityCount,
            'claimedActivityCount' => $claimedActivityCount,
            'points' => $points,
            'nextLevel' => $nextLevel,
            'sActivityDetail' => $sActivityDetail
        ]);
    }

    public function manage(Sukarelawan $sukarelawan)
    {
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

    public function publicUpdate(Request $request, Sukarelawan $sukarelawan)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'max:255',
                'email:dns',
                'regex:/^\S+@\S+\.\S+$/',
                Rule::unique('users')->ignore($sukarelawan->id),
            ],
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'gender' => 'required',
            'dateOfBirth' => 'required|date',
            'picture' => 'sometimes|image',
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

        if ($request->hasFile('picture')) {
            $previousImage = $sukarelawan->profileImageUrl;
            if ($previousImage) {
                Storage::delete('/images' . '/' . $previousImage);
            }
            $pictureFile = $request->file('picture');
            $fileName = $sukarelawan->id . '.' . $pictureFile->getClientOriginalExtension();
            $pictureUrl = $pictureFile->storeAs('/images/Sukarelawan/profileImages', $fileName);
            $pictureUrl = 'Sukarelawan/profileImages/' . $fileName;

            $sukarelawan->update([
                'profileImageUrl' => $pictureUrl
            ]);
        }

        return redirect('/sukarelawans' . '/' . $sukarelawan->slug)->with('success', 'Sukarelawan update successful!');
    }
}
