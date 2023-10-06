<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Generator;
use App\Models\Sukarelawan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\VerificationStatus;

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

    public function destroy(Sukarelawan $sukarelawan)
    {
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
            'profileImage_link' => 'nullable|image',
            'nationalIdentityCardImage_link' => 'nullable|image'
        ]);

        $validated['profileImage_link'] = $sukarelawan->profileImageUrl;
        $validated['nationalIdentityCardImage_link'] = $sukarelawan->nationalIdentityCardImageUrl;

        if ($request->hasFile('profileImage_link')) {
            $validated['profileImage_link'] = $request->file('profileImage_link')->store('images', 'public');
        }

        if ($request->hasFile('nationalIdentityCardImage_link')) {
            $validated['nationalIdentityCardImage_link'] = $request->file('nationalIdentityCardImage_link')->store('images', 'public');
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
            'verified_at' => $verified_at,
            'rejected_at' => $rejected_at,
            'reasonForRejection' => $reasonForRejection,
            'slug' => $slug,
            'profileImageUrl' => $validated['profileImage_link'],
            'nationalIdentityCardImageUrl' => $validated['nationalIdentityCardImage_link']
        ]);

        return redirect('/sukarelawans')->with('success', 'Sukarelawan update successful!');
    }
}
