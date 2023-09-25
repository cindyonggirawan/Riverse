<?php

namespace App\Http\Controllers;

use App\Models\Fasilitator;
use App\Models\Sukarelawan;
use App\Models\User;
use Exception;
use Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function fasilitatorIndex() {
        return view('register.fasilitator.index', [
            'title' => 'Register as a Fasilitator',
            'active' => 'registerFasilitator'
        ]);
    }

    public function sukarelawanIndex() {
        return view('register.sukarelawan.index', [
            'title' => 'Register as a Sukarelawan',
            'active' => 'registerSukarelawan'
        ]);
    }

    public function storeSukarelawan(Request $request) {

        try {
            $validatedSukarelawanData = $request->validate([
                'email' => ['required', 'email:dns', 'unique:sukarelawans'],
                'name' => 'required|max:50',
                'gender_id' => ['required'],
                'password' => ['required', 'min:8', 'max:255', 'alpha_num', 'confirmed'],
                'dateOfBirth' => ['required'],
                'display_picture_link' => ['required', 'image'],
                'ktp_picture_link' => ['required', 'image'],
                'nik' => ['required', 'regex:[^[0-9]+$]']
            ]);

            $request->validate([
                'password_confirmation' => ['required', 'min:8', 'max:255', 'alpha_num']
            ]);

            if ($request->hasFile('display_picture_link')) {
                $validatedSukarelawanData['display_picture_link'] = $request->file('display_picture_link')->store('images', 'public');
            }

            if ($request->hasFile('ktp_picture_link')) {
                $validatedSukarelawanData['ktp_picture_link'] = $request->file('ktp_picture_link')->store('images', 'public');
            }

            $newSukarelawan = new Sukarelawan();
            $newSukarelawan->setPasswordAttribute($validatedSukarelawanData['password']);
            $newSukarelawan->name = $validatedSukarelawanData['name'];
            $newSukarelawan->email = strtolower($validatedSukarelawanData['email']);
            $newSukarelawan->experiencePoint = 0;
            $newSukarelawan->level = 1;
            $newSukarelawan->picture = $validatedSukarelawanData['display_picture_link'];
            $newSukarelawan->identityCardPicture = $validatedSukarelawanData['ktp_picture_link'];
            $newSukarelawan->nationalIdentityNumber = $validatedSukarelawanData['nik'];
            $newSukarelawan->gender = $validatedSukarelawanData['gender_id'];
            $newSukarelawan->status = "UNVERIFIED";
            $newSukarelawan->dateOfBirth = date('Y-m-d', strtotime(str_replace('/', '-', $validatedSukarelawanData['dateOfBirth'])));

            $newUser = new User();
            $newUser->name = $validatedSukarelawanData['name'];
            $newUser->email = strtolower($validatedSukarelawanData['email']);
            $newUser->password = $validatedSukarelawanData['password'];
            $newUser->role_id = 0;

            $newUser->save();
            $newSukarelawan->save();

        } catch(Exception $e) {
            //dd($e->getMessage());
            return redirect('/register/sukarelawan')->with('registrationError',  'Registration Error!');
        }

        return redirect('/login')->with('success', 'Registration successfull! Please login');
    }


    public function storeFasilitator(Request $request) {

        try {
            $validatedFasilitatorData = $request->validate([
                'email' => ['required', 'email:dns', 'unique:fasilitators'],
                'name' => 'required|max:50',
                'password' => ['required', 'min:8', 'max:255', 'alpha_num', 'confirmed'],
                'phoneNumber' => ['required', 'regex:[^[0-9]+$]', 'unique:fasilitators'],
                'type' => ['required'],
                'description' => ['required'],
                'display_picture_link' => ['required', 'image']
            ]);
            $request->validate([
                'password_confirmation' => ['required', 'min:8', 'max:255', 'alpha_num']
            ]);

            if ($request->hasFile('display_picture_link')) {
                $validatedFasilitatorData['display_picture_link'] = $request->file('display_picture_link')->store('images', 'public');
            }

            $newFasilitator = new Fasilitator();
            $newFasilitator->setPasswordAttribute($validatedFasilitatorData['password']);
            $newFasilitator->email = $validatedFasilitatorData['email'];
            $newFasilitator->name = $validatedFasilitatorData['name'];
            $newFasilitator->phoneNumber = $validatedFasilitatorData['phoneNumber'];
            $newFasilitator->description = $validatedFasilitatorData['description'];
            $newFasilitator->type = $validatedFasilitatorData['type'];
            $newFasilitator->picture = $validatedFasilitatorData['display_picture_link'];
            $newFasilitator->status = "UNVERIFIED";

            $newUser = new User();
            $newUser->name = $validatedFasilitatorData['name'];
            $newUser->email = $validatedFasilitatorData['email'];
            $newUser->password = $validatedFasilitatorData['password'];
            $newUser->role_id = 1;

            $newUser->save();
            $newFasilitator->save();

        } catch (Exception $e) {
            //dd($e->getMessage());
            return redirect('/register/fasilitator')->with('registrationError', "Registration Error");
        }

        return redirect('/login')->with('success', 'Registration successfull! Please login');
    }
}
