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
    public function index()
    {
        return view('admin.Tables.Sukarelawan.sukarelawans', [
            'title' => 'Sukarelawans',
            'sukarelawans' => Sukarelawan::orderBy('updated_at', 'desc')
                ->get()
        ]);
    }

    public function show(Sukarelawan $sukarelawan)
    {
        return view('admin.Tables.Sukarelawan.sukarelawan', [
            'title' => 'Sukarelawan',
            'sukarelawan' => $sukarelawan
        ]);
    }

    public function publicShow(Sukarelawan $sukarelawan)
    {
        $levels = Level::orderBy("name")->get();
        // $activities = [];
        // $sActivityDetailsFromDB = $sukarelawan->sukarelawan_activity_details->sortByDesc('updated_at')->paginate(4);
        // if($sActivityDetails !== null && !$sActivityDetails->isEmpty()){
        //     foreach ($sad as $sActivityDetails) {
        //         $correspondingActivity = $sad->activity;
                
        //     }
        //     //append
        // }

        return view('public.sukarelawan', [
            'title' => 'Sukarelawan',
            'sukarelawan' => $sukarelawan,
            'levels' => $levels,
            // 'sActivityDetailsFromDB' => $sActivityDetailsFromDB
            // 'activities' => $activities
        ]);
    }

    public function destroy(Sukarelawan $sukarelawan)
    {
        if ($sukarelawan->nationalIdentityCardImageUrl) {
            Storage::delete($sukarelawan->nationalIdentityCardImageUrl);
        }
        if ($sukarelawan->profileImageUrl) {
            Storage::delete($sukarelawan->profileImageUrl);
        }
        Sukarelawan::destroy($sukarelawan->id);
        User::destroy($sukarelawan->id);

        return redirect('/sukarelawans')->with('success', 'Sukarelawan destruction successful!');
    }

    public function edit(Sukarelawan $sukarelawan)
    {
        return view('admin.Tables.Sukarelawan.edit', [
            'title' => 'Edit Sukarelawan',
            'sukarelawan' => $sukarelawan,
            'verificationStatuses' => VerificationStatus::orderBy('name', 'asc')
                ->get()
        ]);
    }

    public function update(Request $request, Sukarelawan $sukarelawan)
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
            'verificationStatusId' => 'required',
            'reasonForRejection' => 'nullable|string|max:255',
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'gender' => 'required',
            'dateOfBirth' => 'required|date_format:d/m/Y',
            'nationalIdentityNumber' => [
                'required',
                'string',
                'size:16',
                'regex:/^\d{16}$/',
                Rule::unique('sukarelawans')->ignore($sukarelawan->id),
            ],
            'profileImageUrl' => 'nullable|image',
            'nationalIdentityCardImageUrl' => 'nullable|image'
        ]);

        $id = $sukarelawan->id;

        $nationalIdentityCardImageUrl = $sukarelawan->nationalIdentityCardImageUrl;

        $file = $request->file('nationalIdentityCardImageUrl');
        if ($file) {
            $fileName = $id . '.' . $file->getClientOriginalExtension();
            $nationalIdentityCardImageUrl = $file->storeAs('/public/images/Sukarelawan/nationalIdentityCardImages', $fileName);
            $nationalIdentityCardImageUrl = 'Sukarelawan/nationalIdentityCardImages/' . $fileName;
        }

        $profileImageUrl = $sukarelawan->profileImageUrl;

        $fileProfileImage = $request->file('profileImageUrl');
        if ($fileProfileImage) {
            $fileName = $id . '.' . $fileProfileImage->getClientOriginalExtension();
            $profileImageUrl = $fileProfileImage->storeAs('/public/images/Sukarelawan/profileImages', $fileName);
            $profileImageUrl = 'Sukarelawan/profileImages/' . $fileName;
        }

        $slug = $sukarelawan->slug;

        if ($request->name !== $sukarelawan->user->name) {
            $slug = Generator::generateSlug(User::class, $request->name);
        }

        $verified_at = $sukarelawan->verified_at;

        $reasonForRejection = $sukarelawan->reasonForRejection;
        $rejected_at = $sukarelawan->rejected_at;

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

        $user = $sukarelawan->user;

        $user->update([
            'email' => strtolower($request->email),
            'name' => ucwords($request->name),
            'slug' => $slug
        ]);

        $sukarelawan->update([
            'verificationStatusId' => $request->verificationStatusId,
            'gender' => $request->gender,
            'dateOfBirth' => date('Y-m-d', strtotime(str_replace('/', '-', $request->dateOfBirth))),
            'nationalIdentityNumber' => $request->nationalIdentityNumber,
            'nationalIdentityCardImageUrl' => $nationalIdentityCardImageUrl,
            'profileImageUrl' => $profileImageUrl,
            'verified_at' => $verified_at,
            'rejected_at' => $rejected_at,
            'reasonForRejection' => $reasonForRejection,
            'slug' => $slug
        ]);

        return redirect('/sukarelawans')->with('success', 'Sukarelawan update successful!');
    }
}
