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
    public function index()
    {
        return view('admin.Tables.Fasilitator.fasilitators', [
            'title' => 'Fasilitators',
            'fasilitators' => Fasilitator::orderBy('updated_at', 'desc')
                ->get()
        ]);
    }

    public function show(Fasilitator $fasilitator)
    {
        return view('admin.Tables.Fasilitator.fasilitator', [
            'title' => 'Fasilitator',
            'fasilitator' => $fasilitator
        ]);
    }

    public function publicShow(Fasilitator $fasilitator)
    {


        $openStatus = ActivityStatus::where('name', '=', 'Pendaftaran Sedang Dibuka')->first();
        $onGoingStatus  = ActivityStatus::where('name' , '=', 'Aktivitas Sedang Berlangsung')->first();
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

    public function destroy(Fasilitator $fasilitator)
    {
        if ($fasilitator->logoImageUrl) {
            Storage::delete($fasilitator->logoImageUrl);
        }
        Fasilitator::destroy($fasilitator->id);
        User::destroy($fasilitator->id);

        return redirect('/fasilitators')->with('success', 'Fasilitator destruction successful!');
    }

    public function edit(Fasilitator $fasilitator)
    {
        return view('admin.Tables.Fasilitator.edit', [
            'title' => 'Edit Fasilitator',
            'fasilitator' => $fasilitator,
            'verificationStatuses' => VerificationStatus::orderBy('name', 'asc')
                ->get(),
            'fasilitatorTypes' => FasilitatorType::orderBy('name', 'asc')
                ->get()
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

    public function publicUpdate(Fasilitator $fasilitator, Request $request){
        $validated = $request->validate([
            'email' => [
                'required',
                'max:255',
                'email:dns',
                'regex:/^\S+@\S+\.\S+$/',
                Rule::unique('users')->ignore($fasilitator->id),
            ],
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'fasilitatorTypeId' => 'required',
            'description' => 'required|string|max:255',
            'address' => 'required|string|max:255',
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
            
            
            if ($request->picture && $request->picture != "") {
                $request->validate(['picture'=> 'image']);
                $newLogoPic = $request->file('picture');
                if ($fasilitator->logoImageUrl && $fasilitator->logoImageUrl != '') {
                    Storage::delete($fasilitator->logoImageUrl);
                }
                $newLogoPicName = $fasilitator->id . '.' . $newLogoPic->getClientOriginalExtension();
                $logoImageUrl = $newLogoPic->storeAs('images/Sukarelawan/profileImages', $newLogoPicName);

                $fasilitator->update([
                    'logoImageUrl' => $logoImageUrl,
                ]);
            }
            
            return redirect('/fasilitators' . '/' . $fasilitator->slug)->with('success', 'Fasilitator update successful!');
    }

    public function update(Request $request, Fasilitator $fasilitator)
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
            'verificationStatusId' => 'required',
            'reasonForRejection' => 'nullable|string|max:255',
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'fasilitatorTypeId' => 'required',
            'description' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phoneNumber' => [
                'required',
                'string',
                'min:10',
                'max:13',
                'regex:/^(?!62)\d{10,13}$/',
                Rule::unique('fasilitators')->ignore($fasilitator->id),
            ],
            'logoImageUrl' => 'nullable|image'
        ]);

        $id = $fasilitator->id;

        $logoImageUrl = $fasilitator->logoImageUrl;

        $file = $request->file('logoImageUrl');

        if ($file) {
            if ($request->oldLogoImageUrl) {
                Storage::delete($request->oldLogoImageUrl);
            }
            $fileName = $id . '.' . $file->getClientOriginalExtension();
            $logoImageUrl = $file->storeAs('/images/Fasilitator/logoImages', $fileName);
        }

        $slug = $fasilitator->slug;

        if ($request->name !== $fasilitator->user->name) {
            $slug = Generator::generateSlug(User::class, $request->name);
        }

        $verified_at = $fasilitator->verified_at;

        $reasonForRejection = $fasilitator->reasonForRejection;
        $rejected_at = $fasilitator->rejected_at;

        $menungguVerifikasiId = VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id;
        $sudahDiverifikasiId = VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id;
        $sudahDitolakId = VerificationStatus::where('name', 'Sudah Ditolak')->first()->id;

        if ($request->verificationStatusId === $menungguVerifikasiId) {
            $verified_at = null;
            $reasonForRejection = null;
            $rejected_at = null;
        } else if ($request->verificationStatusId === $sudahDiverifikasiId) {
            $verified_at = now();
            $reasonForRejection = null;
            $rejected_at = null;
        } else if ($request->verificationStatusId === $sudahDitolakId) {
            $verified_at = null;
            $reasonForRejection = $request->reasonForRejection;
            $rejected_at = now();
        }

        $user = $fasilitator->user;

        $user->update([
            'email' => strtolower($request->email),
            'name' => ucwords($request->name),
            'slug' => $slug
        ]);

        $fasilitator->update([
            'verificationStatusId' => $request->verificationStatusId,
            'fasilitatorTypeId' => $request->fasilitatorTypeId,
            'description' => $request->description,
            'address' => $request->address,
            'phoneNumber' => $request->phoneNumber,
            'verified_at' => $verified_at,
            'rejected_at' => $rejected_at,
            'reasonForRejection' => $reasonForRejection,
            'logoImageUrl' => $logoImageUrl,
            'slug' => $slug
        ]);

        return redirect('/fasilitators')->with('success', 'Fasilitator update successful!');
    }
}
