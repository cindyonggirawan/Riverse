<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\River;
use App\Models\Activity;
use App\Models\Generator;
use Illuminate\Http\Request;
use App\Models\ActivityStatus;
use App\Models\VerificationStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index()
    {
        return view('admin.Tables.Activity.activities', [
            'title' => 'Activities',
            'activities' => Activity::orderBy('updated_at', 'desc')
                ->get()
        ]);
    }

    public function publicIndex(Request $request)
    {
        $query = Activity::query();

        //TODO: fix this relation
        // // get activites yg sedang dibuka doang!
        // $query->whereHas('activity_statuses', function ($subQuery) {
        //     $subQuery->where('name', 'Sedang Dibuka');
        // });

        //for filtering TODO: clarify this relation
        if ($request->has('searchFasilitator')) {
            $searchFasilitatorName = $request->input('searchFasilitator');
            $query->whereHas('fasilitator.user', function ($subQuery) use ($searchFasilitatorName) {
                $subQuery->where('name', 'like', '%' . $searchFasilitatorName . '%');
            });
        }

        if ($request->has('searchActivity')) {
            $query->where('title', 'like', '%' . $request->input('searchActivity') . '%');
        }

        //for sorting
        if ($request->has('sort')) {
            $sortBy = $request->input('sortBy');

            if ($sortBy === 'dateClosest') {
                $query->orderBy('date');
            } elseif ($sortBy === 'dateFarthest') {
                $query->orderByDesc('date');
            } elseif ($sortBy === 'mostLikes') {
                $query->orderBy('likes', 'desc');
            } elseif ($sortBy === 'leastLikes') {
                $query->orderBy('likes', 'asc');
            }
        } elseif ($request->has('reset')) {
            //reset sorting
        }

        $activities = $query->get();

        // Paginate the results with 9 items per page
        $activities = $query->paginate(9);

        return view('public.activities', [
            'title' => 'Activities',
            'activities' => $activities
        ]);
    }

    public function show(Activity $activity)
    {
        return view('admin.Tables.Activity.activity', [
            'title' => 'Activity',
            'activity' => $activity
        ]);
    }

    public function publicShow()
    {
        // return view("public.activity.fasilitator.activity");
        return view("public.activity.sukarelawan.activity");
    }


    public function create()
    {
        return view('admin.Tables.Activity.create', [
            'title' => 'Create Activity'
        ]);
    }

    public function publicCreate(Request $request, $step = 1)
    {
        return view("public.activity.fasilitator.createStep{$step}", [
            'title' => 'Create Activity',
            'currentStep' => $step,
        ]);
    }

    public function publicStore(Request $request, $step = 1)
    {
        if ($step == 1) {
            $this->handleStep1($request);
        } elseif ($step == 2) {
            $this->handleStep2($request);
        } elseif ($step == 3) {
            $activity = $this->handleStep3($request);
            return redirect()->route('activity.publicShow', ['activity' => $activity->slug]);
        }
        $nextStep = $step + 1;
        return redirect()->route('activity.publicCreate', $nextStep);
    }

    private function handleStep1(Request $request)
    {


        $hasNewImage = $request->hasNewImage;

        $validatedStep1 = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'registrationDeadlineDate' => [
                'required',
                'after:today',
                'before:cleanUpDate'
            ],
            'cleanUpDate' => [
                'required',
                'after:today',
                'after:registrationDeadlineDate'
            ],
            'startTime' => [
                'required',
                'before:endTime',
            ],
            'endTime' => [
                'required',
                'after:startTime',
            ],
            'gatheringPointUrl' => [
                'required',
                'string',
                'regex:#^(https?://)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$#',
            ],
            'picture' => "sometimes|image"
        ]);


        // Check if a picture has been uploaded
        if ($request->hasFile('picture')) {


            $hasNewImage = true;
            $previousPicture = Session::get('step1Data.picture');
            if ($previousPicture) {
                Storage::delete('public/' . $previousPicture);
            }

            $picture = $request->file('picture');
            $pictureName = uniqid() . '_' . $picture->getClientOriginalName();
            $picture->storeAs('public/images', $pictureName);
            $pictureURL = 'images/' . $pictureName;
            $validatedStep1['picture'] = $pictureURL;
        }

        if ($hasNewImage == false) {
            $validatedStep1['picture'] = $request->oldPicture;
        }
        Session::put('step1Data', $validatedStep1);
    }

    private function handleStep2(Request $request)
    {
        $validatedStep2 = $request->validate([
            'sukarelawanJobName' => 'required|string|max:255',
            'sukarelawanJobDetail' => 'required|string',
            'sukarelawanCriteria' => 'required|string',
            'minimumNumOfSukarelawan' => 'required|integer|min:1|max:999',
            'sukarelawanEquipment' => 'required|string',
            'groupChatUrl' => [
                'required',
                'string',
                'regex:#^(https?://)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$#',
            ]
        ]);
        Session::put('step2Data', $validatedStep2);
    }

    private function handleStep3(Request $request)
    {
        $step1Data = Session::get('step1Data');
        $step2Data = Session::get('step2Data');
        $combinedData = array_merge($step1Data, $step2Data);

        $newActivity = Activity::create([
            'id' => Generator::generateId(Activity::class),
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'riverId' => River::where('name', 'Sungai Ciliwung')->first()->id,
            'fasilitatorId' => Auth::user()->id,
            'activityStatusId' => ActivityStatus::where('name', 'Pendaftaran Sedang Dibuka')->first()->id,
            'name' => $combinedData->name,
            'description' => $combinedData->description,
            'registrationDeadlineDate' => date('Y-m-d', strtotime(str_replace('/', '-', $combinedData->registrationDeadlineDate))),
            'cleanUpDate' => date('Y-m-d', strtotime(str_replace('/', '-', $combinedData->cleanUpDate))),
            'startTime' => date('H:i:s', strtotime($combinedData->startTime)),
            'endTime' => date('H:i:s', strtotime($combinedData->endTime)),
            'gatheringPointUrl' => $combinedData->gatheringPointUrl,
            'sukarelawanJobName' => $combinedData->sukarelawanJobName,
            'sukarelawanJobDetail' => $combinedData->sukarelawanJobDetail,
            'sukarelawanCriteria' => $combinedData->sukarelawanCriteria,
            'minimumNumOfSukarelawan' => $combinedData->minimumNumOfSukarelawan,
            'sukarelawanEquipment' => $combinedData->sukarelawanEquipment,
            'groupChatUrl' => $combinedData->groupChatUrl,
            'picture' => $combinedData->picture,
            'slug' => Generator::generateSlug(Activity::class, $combinedData->name)
        ]);

        // Optionally, you can clear the session data for steps 1 and 2 if needed
        Session::forget('step1Data');
        Session::forget('step2Data');

        return $newActivity;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'registrationDeadlineDate' => [
                'required',
                'date_format:d/m/Y',
                'after:today',
                'before:cleanUpDate'
            ],
            'cleanUpDate' => [
                'required',
                'date_format:d/m/Y',
                'after:today',
                'after:registrationDeadlineDate'
            ],
            'startTime' => [
                'required',
                'date_format:H:i',
                'before:endTime',
            ],
            'endTime' => [
                'required',
                'date_format:H:i',
                'after:startTime',
            ],
            'gatheringPointUrl' => [
                'required',
                'string',
                'regex:#^(https?://)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$#',
            ],
            'bannerImageUrl' => 'required|image',
            'sukarelawanJobName' => 'required|string|max:255',
            'sukarelawanJobDetail' => 'required|string',
            'sukarelawanCriteria' => 'required|string',
            'minimumNumOfSukarelawan' => 'required|integer|min:1|max:999',
            'sukarelawanEquipment' => 'required|string',
            'groupChatUrl' => [
                'required',
                'string',
                'regex:#^(https?://)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$#',
            ]
        ]);

        $id = Generator::generateId(Activity::class);

        $file = $request->file('bannerImageUrl');
        $bannerImageUrl = null;
        if ($file) {
            $fileName = $id . '.' . $file->getClientOriginalExtension();
            $bannerImageUrl = $file->storeAs('Activity/bannerImages', $fileName);
        }

        Activity::create([
            'id' => $id,
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'riverId' => River::where('name', 'Sungai Ciliwung')->first()->id,
            'fasilitatorId' => Auth::user()->id,
            'activityStatusId' => ActivityStatus::where('name', 'Pendaftaran Sedang Dibuka')->first()->id,
            'name' => $request->name,
            'description' => $request->description,
            'registrationDeadlineDate' => date('Y-m-d', strtotime(str_replace('/', '-', $request->registrationDeadlineDate))),
            'cleanUpDate' => date('Y-m-d', strtotime(str_replace('/', '-', $request->cleanUpDate))),
            'startTime' => date('H:i:s', strtotime($request->startTime)),
            'endTime' => date('H:i:s', strtotime($request->endTime)),
            'gatheringPointUrl' => $request->gatheringPointUrl,
            'bannerImageUrl' => $bannerImageUrl,
            'sukarelawanJobName' => $request->sukarelawanJobName,
            'sukarelawanJobDetail' => $request->sukarelawanJobDetail,
            'sukarelawanCriteria' => $request->sukarelawanCriteria,
            'minimumNumOfSukarelawan' => $request->minimumNumOfSukarelawan,
            'sukarelawanEquipment' => $request->sukarelawanEquipment,
            'groupChatUrl' => $request->groupChatUrl,
            'slug' => Generator::generateSlug(Activity::class, $request->name)
        ]);

        return redirect('/manage/activities')->with('success', 'Activity creation successful!');
    }

    public function destroy(Activity $activity)
    {
        if ($activity->bannerImageUrl) {
            Storage::delete($activity->bannerImageUrl);
        }
        $activity->delete();
        return redirect('/manage/activities')->with('success', 'Activity destruction successful!');
    }

    public function edit(Activity $activity)
    {
        return view('admin.Tables.Activity.edit', [
            'title' => 'Edit Activity',
            'activity' => $activity,
            'verificationStatuses' => VerificationStatus::orderBy('name', 'asc')
                ->get()
        ]);
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'registrationDeadlineDate' => [
                'required',
                'date_format:d/m/Y',
                'before:cleanUpDate'
            ],
            'verificationStatusId' => 'required',
            'reasonForRejection' => 'nullable|string|max:255',
            'cleanUpDate' => [
                'required',
                'date_format:d/m/Y',
                'after:registrationDeadlineDate'
            ],
            'startTime' => [
                'required',
                'date_format:H:i',
                'before:endTime',
            ],
            'endTime' => [
                'required',
                'date_format:H:i',
                'after:startTime',
            ],
            'gatheringPointUrl' => [
                'required',
                'string',
                'regex:#^(https?://)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$#',
            ],
            'bannerImageUrl' => 'required|image',
            'sukarelawanJobName' => 'required|string|max:255',
            'sukarelawanJobDetail' => 'required|string',
            'sukarelawanCriteria' => 'required|string',
            'minimumNumOfSukarelawan' => 'required|integer|min:1|max:999',
            'sukarelawanEquipment' => 'required|string',
            'groupChatUrl' => [
                'required',
                'string',
                'regex:#^(https?://)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$#',
            ],
            'experiencePointGiven' => 'nullable|integer|min:0|max:999'
        ]);

        $id = $activity->id;

        $file = $request->file('bannerImageUrl');
        if ($file) {
            if ($request->oldBannerImageUrl) {
                Storage::delete($request->oldBannerImageUrl);
            }
            $fileName = $id . '.' . $file->getClientOriginalExtension();
            $bannerImageUrl = $file->storeAs('Activity/bannerImages', $fileName);
        } else {
            $bannerImageUrl = $activity->bannerImageUrl;
        }

        $slug = $activity->slug;

        if ($request->name !== $activity->name) {
            $slug = Generator::generateSlug(Activity::class, $request->name);
        }

        $experiencePointGiven = $activity->experiencePointGiven;
        $verified_at = $activity->verified_at;

        $reasonForRejection = $activity->reasonForRejection;
        $rejected_at = $activity->rejected_at;

        $menungguVerifikasiId = VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id;
        $sudahDiverifikasiId = VerificationStatus::where('name', 'Sudah Diverifikasi')->first()->id;
        $sudahDitolakId = VerificationStatus::where('name', 'Sudah Ditolak')->first()->id;

        if ($request->verificationStatusId === $menungguVerifikasiId) {
            $experiencePointGiven = 0;
            $verified_at = null;
            $reasonForRejection = null;
            $rejected_at = null;
        } else if ($request->verificationStatusId === $sudahDiverifikasiId) {
            $experiencePointGiven = $request->experiencePointGiven;
            $verified_at = now();
            $reasonForRejection = null;
            $rejected_at = null;
        } else if ($request->verificationStatusId === $sudahDitolakId) {
            $experiencePointGiven = 0;
            $verified_at = null;
            $reasonForRejection = $request->reasonForRejection;
            $rejected_at = now();
        }

        $activityStatusId = $activity->activityStatusId;

        $requestRegistrationDeadlineDate = date('Y-m-d', strtotime(str_replace('/', '-', $request->registrationDeadlineDate)));
        $requestCleanUpDate = date('Y-m-d', strtotime(str_replace('/', '-', $request->cleanUpDate)));
        $requestStartTime = date('H:i:s', strtotime($request->startTime));
        $requestEndTime = date('H:i:s', strtotime($request->endTime));

        $now = Carbon::now();

        $pendaftaranSedangDibukaId = ActivityStatus::where('name', 'Pendaftaran Sedang Dibuka')->first()->id;
        $pendaftaranSudahDitutupId = ActivityStatus::where('name', 'Pendaftaran Sudah Ditutup')->first()->id;
        $aktivitasBelumDimulaiId = ActivityStatus::where('name', 'Aktivitas Belum Dimulai')->first()->id;
        $aktivitasSedangBerlangsungId = ActivityStatus::where('name', 'Aktivitas Sedang Berlangsung')->first()->id;
        $aktivitasSudahSelesaiId = ActivityStatus::where('name', 'Aktivitas Sudah Selesai')->first()->id;

        if ($request->verificationStatusId === $sudahDiverifikasiId) {
            if (
                $requestRegistrationDeadlineDate !== $activity->registrationDeadlineDate ||
                $requestCleanUpDate !== $activity->cleanUpDate ||
                $requestStartTime !== $activity->startTime ||
                $requestEndTime !== $activity->endTime
            ) {
                $registrationDeadlineDate = Carbon::parse($requestRegistrationDeadlineDate);
                $cleanUpDate = Carbon::parse($requestCleanUpDate);
                $cleanUpDate_ = Carbon::parse($requestCleanUpDate);
                $cleanUpDate__ = Carbon::parse($requestCleanUpDate);

                $startTime_ = Carbon::parse($requestStartTime);
                $startTime = $cleanUpDate_->setTime($startTime_->hour, $startTime_->minute, $startTime_->second);

                $endTime__ = Carbon::parse($requestEndTime);
                $endTime = $cleanUpDate__->setTime($endTime__->hour, $endTime__->minute, $endTime__->second);

                if ($now >= $endTime && $now >= $startTime && $now >= $cleanUpDate && $now >= $registrationDeadlineDate) {
                    $activityStatusId = $aktivitasSudahSelesaiId;
                } else if ($now < $endTime && $now >= $startTime && $now >= $cleanUpDate && $now >= $registrationDeadlineDate) {
                    $activityStatusId = $aktivitasSedangBerlangsungId;
                } else if ($now < $endTime && $now < $startTime && $now >= $cleanUpDate && $now >= $registrationDeadlineDate) {
                    $activityStatusId = $aktivitasBelumDimulaiId;
                } else if ($now < $endTime && $now < $startTime && $now < $cleanUpDate && $now >= $registrationDeadlineDate) {
                    $activityStatusId = $pendaftaranSudahDitutupId;
                } else if ($now < $endTime && $now < $startTime && $now < $cleanUpDate && $now < $registrationDeadlineDate) {
                    $activityStatusId = $pendaftaranSedangDibukaId;
                }
            }
        }

        $activity->update([
            'verificationStatusId' => $request->verificationStatusId,
            'activityStatusId' => $activityStatusId,
            'name' => $request->name,
            'description' => $request->description,
            'registrationDeadlineDate' => $requestRegistrationDeadlineDate,
            'cleanUpDate' => $requestCleanUpDate,
            'startTime' => $requestStartTime,
            'endTime' => $requestEndTime,
            'gatheringPointUrl' => $request->gatheringPointUrl,
            'bannerImageUrl' => $bannerImageUrl,
            'sukarelawanJobName' => $request->sukarelawanJobName,
            'sukarelawanJobDetail' => $request->sukarelawanJobDetail,
            'sukarelawanCriteria' => $request->sukarelawanCriteria,
            'minimumNumOfSukarelawan' => $request->minimumNumOfSukarelawan,
            'sukarelawanEquipment' => $request->sukarelawanEquipment,
            'groupChatUrl' => $request->groupChatUrl,
            'experiencePointGiven' => $experiencePointGiven,
            'verified_at' => $verified_at,
            'rejected_at' => $rejected_at,
            'reasonForRejection' => $reasonForRejection,
            'slug' => $slug
        ]);

        return redirect('/manage/activities')->with('success', 'Activity update successful!');
    }
}
