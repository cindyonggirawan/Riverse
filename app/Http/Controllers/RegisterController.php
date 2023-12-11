<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Level;
use App\Models\Generator;
use App\Models\Fasilitator;
use App\Models\Sukarelawan;
use Illuminate\Http\Request;
use App\Models\FasilitatorType;
use App\Models\VerificationStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function showSukarelawan($step = 1)
    {
        return view("admin.Tables.Sukarelawan.register.registerStep{$step}", [
            'title' => 'Register as Sukarelawan',
            'currentStep' => $step
        ]);
    }

    public function storeSukarelawan(Request $request, $step = 1)
    {
        if ($step == 1) {
            $this->handleRegisterSukarelawanStep1($request);
        } elseif ($step == 2) {
            $this->handleRegisterSukarelawanStep2($request);
        } elseif ($step == 3) {
            $this->handleRegisterSukarelawanStep3($request);
            return redirect('/login')->with('success', 'Sukarelawan registration successful!');
        }
        $nextStep = $step + 1;
        return redirect()->route('sukarelawan.show', $nextStep);
    }

    private function handleRegisterSukarelawanStep1(Request $request)
    {
        $validatedStep1 = $request->validate([
            'email' => 'required|string|max:255|email:dns|regex:/^\S+@\S+\.\S+$/|unique:users',
            'password' => 'required|string|min:8|max:16|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,16}$/|confirmed'
        ]);

        Session::put('step1Data', $validatedStep1);
    }

    private function handleRegisterSukarelawanStep2(Request $request)
    {
        $hasNewImage = $request->hasNewImage;

        $validatedStep2 = $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'gender' => 'required',
            'dateOfBirth' => 'required|date',
            'nationalIdentityNumber' => 'required|string|size:16|regex:/^\d{16}$/|unique:sukarelawans',
            'nationalIdentityCardImageUrl' => 'required|image'
        ]);

        $nationalIdentityCardImageFile = $request->file('nationalIdentityCardImageUrl');

        if ($nationalIdentityCardImageFile) {
            $hasNewImage = true;
            $previousImage = Session::get('step2Data.nationalIdentityCardImageUrl');
            if ($previousImage) {
                Storage::delete($previousImage);
            }
            $fileName = uniqid() . '.' . $nationalIdentityCardImageFile->getClientOriginalExtension();
            $nationalIdentityCardImageUrl = $nationalIdentityCardImageFile->storeAs('/public/images/Sukarelawan/nationalIdentityCardImages', $fileName);
            $nationalIdentityCardImageUrl ='Sukarelawan/nationalIdentityCardImages/' . $fileName;
            $validatedStep2['nationalIdentityCardImageUrl'] = $nationalIdentityCardImageUrl;
        }

        if ($hasNewImage == false) {
            $validatedStep2['nationalIdentityCardImageUrl'] = $request->oldNationalIdentityCardImageUrl;
        }

        Session::put('step2Data', $validatedStep2);
    }

    public function handleRegisterSukarelawanStep3()
    {
        $step1Data = Session::get('step1Data');
        $step2Data = Session::get('step2Data');
        $combinedData = array_merge($step1Data, $step2Data);
        $request = new Request($combinedData);

        $id = Generator::generateId(Sukarelawan::class);

        //uncomment dlu biar bisa save nationalIdentityCardImageUrl
/*
        $oldFileUrl = $request->nationalIdentityCardImageUrl;
        $directoryPath = pathinfo($oldFileUrl, PATHINFO_DIRNAME);
        $fileExtension = pathinfo($oldFileUrl, PATHINFO_EXTENSION);

        $newFileName = $id . '.' . $fileExtension;
        $newFileUrl = $directoryPath . '/' . $newFileName;

        Storage::move($oldFileUrl, $newFileUrl);
*/

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
            'nationalIdentityCardImageUrl' => $request->nationalIdentityCardImageUrl,
            'slug' => $slug
        ]);

        Session::forget('step1Data');
        Session::forget('step2Data');
    }

    public function showFasilitator($step = 1)
    {
        return view("admin.Tables.Fasilitator.register.registerStep{$step}", [
            'title' => 'Register as Fasilitator',
            'fasilitatorTypes' => FasilitatorType::orderBy('name', 'asc')
                ->get(),
            'currentStep' => $step
        ]);
    }

    public function storeFasilitator(Request $request, $step = 1)
    {
        if ($step == 1) {
            $this->handleRegisterFasilitatorStep1($request);
        } elseif ($step == 2) {
            $this->handleRegisterFasilitatorStep2($request);
        } elseif ($step == 3) {
            $this->handleRegisterFasilitatorStep3($request);
        } elseif ($step == 4) {
            $this->handleRegisterFasilitatorStep4($request);
            return redirect('/login')->with('success', 'Fasilitator registration successful!');
        }
        $nextStep = $step + 1;
        return redirect()->route('fasilitator.show', $nextStep);
    }

    private function handleRegisterFasilitatorStep1(Request $request)
    {
        $validatedStep1 = $request->validate([
            'email' => 'required|string|max:255|email:dns|regex:/^\S+@\S+\.\S+$/|unique:users',
            'password' => 'required|string|min:8|max:16|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,16}$/|confirmed',
        ]);

        Session::put('step1Data', $validatedStep1);
    }

    private function handleRegisterFasilitatorStep2(Request $request)
    {
        $hasNewImage = $request->hasNewImage;

        $validatedStep2 = $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'fasilitatorTypeId' => 'required',
            'description' => 'required|string|min:100|max:255',
            'logoImageUrl' => 'required|image'
        ]);

        if ($request->hasFile('logoImageUrl')) {
            $hasNewImage = true;
            $previousImage = Session::get('step2Data.logoImageUrl');
            if ($previousImage) {
                Storage::delete($previousImage);
            }

            $logoImageFile = $request->file('logoImageUrl');
            $fileName = uniqid() . '.' . $logoImageFile->getClientOriginalExtension();
            $logoImageUrl = $logoImageFile->storeAs('/public/images/Fasilitator/logoImages', $fileName);
            $logoImageUrl = 'Fasilitator/logoImages/' . $fileName;
            $validatedStep2['logoImageUrl'] = $logoImageUrl;
        }

        if ($hasNewImage == false) {
            $validatedStep2['logoImageUrl'] = $request->oldLogoImageUrl;
        }

        Session::put('step2Data', $validatedStep2);
    }

    private function handleRegisterFasilitatorStep3(Request $request)
    {
        $validatedStep3 = $request->validate([
            'address' => 'required|string|min:10|max:255',
            'phoneNumber' => 'required|string|min:10|max:13|regex:/^(?!62)\d{10,13}$/|unique:fasilitators'
        ]);

        Session::put('step3Data', $validatedStep3);
    }

    public function handleRegisterFasilitatorStep4()
    {
        $step1Data = Session::get('step1Data');
        $step2Data = Session::get('step2Data');
        $step3Data = Session::get('step3Data');
        $combinedData = array_merge($step1Data, $step2Data, $step3Data);
        $request = new Request($combinedData);

        $id = Generator::generateId(Fasilitator::class);

        $oldFileUrl = $request->logoImageUrl;
        $directoryPath = pathinfo($oldFileUrl, PATHINFO_DIRNAME);
        $fileExtension = pathinfo($oldFileUrl, PATHINFO_EXTENSION);

        $newFileName = $id . '.' . $fileExtension;
        $newFileUrl = $directoryPath . '/' . $newFileName;

        Storage::move($oldFileUrl, $newFileUrl);

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
            'logoImageUrl' => $newFileUrl,
            'slug' => $slug
        ]);

        Session::forget('step1Data');
        Session::forget('step2Data');
        Session::forget('step3Data');
    }
}
