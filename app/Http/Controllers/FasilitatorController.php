<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityStatus;

use App\Models\Generator;
use App\Models\Fasilitator;
use Illuminate\Http\Request;
use App\Models\FasilitatorType;
use Illuminate\Validation\Rule;
use App\Models\VerificationStatus;
use Illuminate\Support\Facades\Storage;

class FasilitatorController extends Controller
{
    public function publicShow(Fasilitator $fasilitator)
    {
        $openStatus = ActivityStatus::where('name', '=', 'Pendaftaran Sedang Dibuka')->first();
        $onGoingStatus  = ActivityStatus::where('name', '=', 'Aktivitas Sedang Berlangsung')->first();
        $finishStatus = ActivityStatus::where('name', '=', 'Aktivitas Sudah Selesai')->first();

        $allActivities = Activity::where('fasilitatorId', '=', $fasilitator->id)->get();

        $openActivities = $allActivities->where('activityStatusId', $openStatus->id);
        $ongoingActivities = $allActivities->where('activityStatusId', $onGoingStatus->id);
        $finishActivitiesCount = $allActivities->where('activityStatusId', $finishStatus->id)->count() ?? 0;


        return view('public.fasilitator.profile', [
            'title' => 'Fasilitator',
            'fasilitator' => $fasilitator,
            'openActivities' => $openActivities,
            'ongoingActivities' => $ongoingActivities,
            'finishActivitiesCount' => $finishActivitiesCount,
        ]);
    }

    public function manage(Fasilitator $fasilitator)
    {
        $activities = $fasilitator->activities()->orderBy('created_at', 'desc')->get();

        return view('public.fasilitator.manage', [
            'title' => 'Sukarelawan',
            'fasilitator' => $fasilitator,
            'activities' => $activities
        ]);
    }

    public function publicEdit(Fasilitator $fasilitator)
    {
        return view('public.fasilitator.edit', [
            'title' => 'Edit Fasilitator',
            'fasilitator' => $fasilitator,
            'fasilitatorTypes' => FasilitatorType::orderBy('name', 'asc')
                ->get()
        ]);
    }

    public function publicUpdate(Fasilitator $fasilitator, Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'max:255',
                'email:dns',
                'regex:/^\S+@\S+\.\S+$/',
                Rule::unique('users')->ignore($fasilitator->id),
            ],
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'fasilitatorTypeId' => 'required',
            'description' => 'required|string|min:100|max:255',
            'picture' => 'sometimes|image',
            'address' => 'required|string|min:10|max:255',
            'phoneNumber' => [
                'required',
                'string',
                'min:10',
                'max:13',
                'regex:/^(?!62)\d{10,13}$/',
                Rule::unique('fasilitators')->ignore($fasilitator->id),
            ],
        ]);

        $slug = $fasilitator->slug;

        if ($request->name !== $fasilitator->user->name) {
            $slug = Generator::generateSlug(User::class, $request->name);
        }

        $user = $fasilitator->user;
        $user->update([
            'email' => strtolower($request->email),
            'name' => ucwords($request->name),
            'slug' => $slug
        ]);
        $fasilitator->update([
            'fasilitatorTypeId' => $request->fasilitatorTypeId,
            'description' => $request->description,
            'address' => $request->address,
            'phoneNumber' => $request->phoneNumber,
            'slug' => $slug
        ]);

        if ($request->hasFile('picture')) {
            $previousImage = $fasilitator->logoImageUrl;
            if ($previousImage) {
                Storage::delete('/images' . '/' . $previousImage);
            }
            $pictureFile = $request->file('picture');
            $fileName = $fasilitator->id . '.' . $pictureFile->getClientOriginalExtension();
            $pictureUrl = $pictureFile->storeAs('/images/Fasilitator/logoImages', $fileName);
            $pictureUrl = 'Fasilitator/logoImages/' . $fileName;

            $fasilitator->update([
                'logoImageUrl' => $pictureUrl
            ]);
        }

        return redirect('/fasilitators' . '/' . $fasilitator->slug)->with('success', 'Fasilitator update successful!');
    }
}
