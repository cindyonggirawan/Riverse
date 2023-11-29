<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            'logoImageUrl' => 'required|image'
        ]);

        $id = $fasilitator->id;

        $file = $request->file('logoImageUrl');
        if ($file) {
            if ($request->oldLogoImageUrl) {
                Storage::delete($request->oldLogoImageUrl);
            }
            $fileName = $id . '.' . $file->getClientOriginalExtension();
            $logoImageUrl = $file->storeAs('Fasilitator/logoImages', $fileName);
        } else {
            $logoImageUrl = $fasilitator->logoImageUrl;
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
