<?php

namespace App\Http\Controllers;

use App\Models\Fasilitator;
use App\Models\FasilitatorType;
use App\Models\Role;
use App\Models\User;
use App\Models\Generator;
use App\Models\Level;
use App\Models\Sukarelawan;
use App\Models\VerificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('admin.Tables.User.register', [
            'title' => 'Register'
        ]);
    }

    public function showSukarelawan()
    {
        return view('admin.Tables.Sukarelawan.register', [
            'title' => 'Register as Sukarelawan'
        ]);
    }

    public function storeSukarelawan(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|max:255|email:dns|regex:/^\S+@\S+\.\S+$/|unique:users',
            'password' => 'required|string|min:8|max:16|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,16}$/|confirmed',
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'gender' => 'required',
            'dateOfBirth' => 'required|date_format:d/m/Y',
            'nationalIdentityNumber' => 'required|string|size:16|regex:/^\d{16}$/|unique:sukarelawans',
            'nationalIdentityCardImageUrl' => 'required|image',
            'profileImageUrl' => 'required|image'
        ]);

        $id = Generator::generateId(Sukarelawan::class);

        $file = $request->file('nationalIdentityCardImageUrl');
        $fileProfileImage = $request->file('profileImageUrl');

        $nationalIdentityCardImageUrl = null;
        $profileImageUrl = null;

        if ($file) {
            $fileName = $id . '.' . $file->getClientOriginalExtension();
            $nationalIdentityCardImageUrl = $file->storeAs('/public/images/Sukarelawan/nationalIdentityCardImages', $fileName);
            $nationalIdentityCardImageUrl ='Sukarelawan/nationalIdentityCardImages/' . $fileName;
        }
        if ($fileProfileImage) {
            $fileName = $id . '.' . $fileProfileImage->getClientOriginalExtension();
            $profileImageUrl = $fileProfileImage->storeAs('/public/images/Sukarelawan/profileImages', $fileName);
            $profileImageUrl = 'Sukarelawan/profileImages/' . $fileName;
        }

        $slug = Generator::generateSlug(User::class, $request->name);

        User::create([
            'id' => $id,
            'roleId' => Role::where('name', 'Sukarelawan')->first()->id,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'name' => ucwords($request->name),
            'slug' => $slug
        ]);

        Sukarelawan::create([
            'id' => $id,
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'levelId' => Level::where('name', 'Level 1')->first()->id,
            'gender' => $request->gender,
            'dateOfBirth' => date('Y-m-d', strtotime(str_replace('/', '-', $request->dateOfBirth))),
            'nationalIdentityNumber' => $request->nationalIdentityNumber,
            'nationalIdentityCardImageUrl' => $nationalIdentityCardImageUrl,
            'profileImageUrl' => $profileImageUrl,
            'slug' => $slug
        ]);

        return redirect('/login')->with('success', 'Sukarelawan registration successful!');
    }

    public function showFasilitator()
    {
        return view('admin.Tables.Fasilitator.register', [
            'title' => 'Register as Fasilitator',
            'fasilitatorTypes' => FasilitatorType::orderBy('name', 'asc')
                ->get()
        ]);
    }

    public function storeFasilitator(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|max:255|email:dns|regex:/^\S+@\S+\.\S+$/|unique:users',
            'password' => 'required|string|min:8|max:16|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,16}$/|confirmed',
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'fasilitatorTypeId' => 'required',
            'description' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phoneNumber' => 'required|string|min:10|max:13|regex:/^(?!62)\d{10,13}$/|unique:fasilitators',
            'logoImageUrl' => 'required|image'
        ]);

        $id = Generator::generateId(Fasilitator::class);

        $file = $request->file('logoImageUrl');
        $logoImageUrl = null;
        if ($file) {
            $fileName = $id . '.' . $file->getClientOriginalExtension();
            $logoImageUrl = $file->storeAs('Fasilitator/logoImages', $fileName);
        }

        $slug = Generator::generateSlug(User::class, $request->name);

        User::create([
            'id' => $id,
            'roleId' => Role::where('name', 'Fasilitator')->first()->id,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'name' => ucwords($request->name),
            'slug' => $slug
        ]);

        Fasilitator::create([
            'id' => $id,
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'fasilitatorTypeId' => $request->fasilitatorTypeId,
            'description' => $request->description,
            'address' => $request->address,
            'phoneNumber' => $request->phoneNumber,
            'logoImageUrl' => $logoImageUrl,
            'slug' => $slug
        ]);

        return redirect('/login')->with('success', 'Fasilitator registration successful!');
    }
}
