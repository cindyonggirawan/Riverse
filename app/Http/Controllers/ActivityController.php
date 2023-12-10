<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\River;
use App\Models\Activity;
use App\Models\Generator;
use Illuminate\Http\Request;
use App\Models\ActivityStatus;
use App\Models\Fasilitator;
use App\Models\VerificationStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\SukarelawanActivityDetail;
use App\Models\SukarelawanActivityStatus;

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
         // filter by activityStatusId
         $query->whereHas('activityStatus', function ($subQuery) {
            $subQuery->where('name', 'Pendaftaran Sedang Dibuka');
        });

        if ($request->has('searchFasilitator')) {
            $searchFasilitatorName = $request->input('searchFasilitator');
            $query->whereHas('fasilitator.user', function ($subQuery) use ($searchFasilitatorName) {
                $subQuery->where('name', 'like', '%' . $searchFasilitatorName . '%');
            });
        }

        if ($request->has('searchActivity')) {
            $query->where('name', 'like', '%' . $request->input('searchActivity') . '%');
        }

        //for sorting
        if ($request->has('sort')) {
            $sortBy = $request->input('sortBy');

            if ($sortBy === 'dateClosest') {
                $query->orderBy('cleanUpDate');
            }
            elseif ($sortBy === 'dateFarthest') {
                $query->orderByDesc('cleanUpDate');
            }
            elseif ($sortBy === 'mostLikes') {
                $query->withCount(['sukarelawan_activity_details as like_count' => function ($query) {
                    $query->where('isLiked', true);
                }])->orderByDesc('like_count');
            }
            elseif ($sortBy === 'leastLikes') {
                $query->withCount(['sukarelawan_activity_details as like_count' => function ($query) {
                    $query->where('isLiked', true);
                }])->orderBy('like_count');
            }
        } elseif ($request->has('reset')) {
            //reset sorting
            $query->latest();
        }

        $activities = $query->get();

        // Paginate the results with 9 items per page
        $activities = $query->paginate(9);

        return view('public.activities', [
            'title' => 'Activities',
            'activities' => $activities,
            "searchActivity" => $request->input("searchActivity"),
            "searchFasilitator" => $request->input("searchFasilitator"),
        ]);
    }

    public function show(Activity $activity)
    {
        return view('admin.Tables.Activity.activity', [
            'title' => 'Activity',
            'activity' => $activity
        ]);
    }

    public function publicShow(Activity $activity)
    {
        $user = auth()->user();
        $likeCount = $activity->likeCount();
        // dd($likeCount);

        if ($user != null) {
            if (str_starts_with($user->id, 'FR')) {
                return view('public.activity.fasilitator.activity', [
                    'title' => 'Activity',
                    'activity' => $activity,
                    'likeCount' => $likeCount,
                ]);
            } else {
                return view('public.activity.sukarelawan.activity', [
                    'title' => 'Activity',
                    'activity' => $activity,
                    'likeCount' => $likeCount,
                ]);
            }
        } else {
            return view('public.activity.guest.activity', [
                'title' => 'Activity',
                'activity' => $activity,
                'likeCount' => $likeCount,
            ]);
        }
    }



    public function create()
    {
        return view('admin.Tables.Activity.create', [
            'title' => 'Create Activity'
        ]);
    }

    public function publicCreate(Request $request, $step = 1)
    {
        return view("public.activity.fasilitator.create.createStep{$step}", [
            'title' => 'Create Activity',
            'currentStep' => $step,
        ]);
    }

    public function publicStore(Request $request, $step = 1)
    {
        if ($step == 1) {
            $this->handleCreateStep1($request);
        } elseif ($step == 2) {
            $this->handleCreateStep2($request);
        } elseif ($step == 3) {
            $activity = $this->handleCreateStep3($request);
            return redirect()->route('activity.publicShow', ['activity' => $activity->slug]);
        }
        $nextStep = $step + 1;
        return redirect()->route('activity.publicCreate', $nextStep);
    }

    private function handleCreateStep1(Request $request)
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
                Storage::delete('public/images' . $previousPicture);
            }

            $picture = $request->file('picture');
            $pictureName = uniqid() . '_' . $picture->getClientOriginalName();
            $bannerImageUrl = $picture->storeAs('Activity/bannerImages', $pictureName);
            $validatedStep1['picture'] = $bannerImageUrl;
        }

        if ($hasNewImage == false) {
            $validatedStep1['picture'] = $request->oldPicture;
        }
        Session::put('step1Data', $validatedStep1);
    }

    private function handleCreateStep2(Request $request)
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

    private function handleCreateStep3(Request $request)
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
            'name' => $combinedData["name"],
            'description' => $combinedData["description"],
            'registrationDeadlineDate' => date('Y-m-d', strtotime(str_replace('/', '-', $combinedData["registrationDeadlineDate"]))),
            'cleanUpDate' => date('Y-m-d', strtotime(str_replace('/', '-', $combinedData["cleanUpDate"]))),
            'startTime' => date('H:i:s', strtotime($combinedData['startTime'])),
            'endTime' => date('H:i:s', strtotime($combinedData["endTime"])),
            'gatheringPointUrl' => $combinedData["gatheringPointUrl"],
            'sukarelawanJobName' => $combinedData["sukarelawanJobName"],
            'sukarelawanJobDetail' => $combinedData["sukarelawanJobDetail"],
            'sukarelawanCriteria' => $combinedData["sukarelawanCriteria"],
            'minimumNumOfSukarelawan' => $combinedData["minimumNumOfSukarelawan"],
            'sukarelawanEquipment' => $combinedData["sukarelawanEquipment"],
            'groupChatUrl' => $combinedData["groupChatUrl"],
            'bannerImageUrl' => $combinedData["picture"],
            'slug' => Generator::generateSlug(Activity::class, $combinedData["name"])
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
            $bannerImageUrl = $file->storeAs('/public/images/Activity/bannerImages', $fileName);
            $bannerImageUrl = 'Activity/bannerImages/' . $fileName;
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

    public function publicDestroy(Activity $activity)
    {
        if($activity->fasilitator->id != auth()->user()->fasilitator->id){
            return redirect('/');
        }// validate if this is the correct fasilitator

        if($activity->verificationStatus->name != "Sudah Diverifikasi"){
            if ($activity->bannerImageUrl) {
                Storage::delete($activity->bannerImageUrl);
            }
            $activity->delete();
            return redirect('fasilitators/'. 
            auth()->user()->fasilitator->slug
            .'/manage')->with('success', 'Activity destruction successful!');
        } //
        
        
        return redirect('/');
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

    public function publicEdit(Activity $activity, $step = 1)
    {
        // $this->authorize('update', $activity);
        if(Auth::check() && auth()->user()->fasilitator !== null && $activity->fasilitatorId == auth()->user()->fasilitator->id) {
            return view("public.activity.fasilitator.update.updateStep{$step}", [
                'title' => 'Edit Activity',
                'activity' => $activity,
                'currentStep' => $step,
                'verificationStatuses' => VerificationStatus::orderBy('name', 'asc')
                    ->get()
            ]);
        } else {
            $activities = Activity::latest()->limit(9)->get();
            return view('home', [
                'activities' => $activities,
                'activitiesCount' => Activity::all()->count(),
                'sukarelawanCount' => SukarelawanActivityDetail::all()->count(),
                'fasilitatorCount' => Fasilitator::all()->count(),
            ]);
        }
    }

    public function publicUpdate(Request $request, Activity $activity, $step = 1)
    {
        $step = (int) $step;

        if ($step == 1) {
            $this->handleUpdateStep1($request);
        } elseif ($step == 2) {
            $this->handleUpdateStep2($request);
        } elseif ($step == 3) {
            $newSlug =  $this->handleUpdateStep3($request, $activity);
            return redirect()->route('activity.publicShow', ['activity' => $newSlug]);
        }
        $nextStep = $step + 1;
        return redirect()->route('activity.publicEdit', ['activity' => $activity->slug, "step" => $nextStep]);
    }




    private function handleUpdateStep1(Request $request)
    {
        // $hasNewImage = $request->hasNewImage;

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
            ]
        ]);

        Session::put('step1DataUpdate', $validatedStep1);
    }

    private function handleUpdateStep2(Request $request)
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
        Session::put('step2DataUpdate', $validatedStep2);
    }

    private function handleUpdateStep3(Request $request, Activity $activity)
    {
        $step1Data = Session::get('step1DataUpdate');
        $step2Data = Session::get('step2DataUpdate');
        $combinedData = array_merge($step1Data, $step2Data);

        $activity->update([
            'name' => $combinedData["name"],
            'description' => $combinedData["description"],
            'registrationDeadlineDate' => date('Y-m-d', strtotime(str_replace('/', '-', $combinedData["registrationDeadlineDate"]))),
            'cleanUpDate' => date('Y-m-d', strtotime(str_replace('/', '-', $combinedData["cleanUpDate"]))),
            'startTime' => date('H:i:s', strtotime($combinedData["startTime"])),
            'endTime' => date('H:i:s', strtotime($combinedData["endTime"])),
            'gatheringPointUrl' => $combinedData["gatheringPointUrl"],
            'sukarelawanJobName' => $combinedData["sukarelawanJobName"],
            'sukarelawanJobDetail' => $combinedData["sukarelawanJobDetail"],
            'sukarelawanCriteria' => $combinedData["sukarelawanCriteria"],
            'minimumNumOfSukarelawan' => $combinedData["minimumNumOfSukarelawan"],
            'sukarelawanEquipment' => $combinedData["sukarelawanEquipment"],
            'groupChatUrl' => $combinedData['groupChatUrl'],
            'slug' => Generator::generateSlug(Activity::class, $combinedData['name'])
        ]);

        Session::forget('step1DataUpdate');
        Session::forget('step2DataUpdate');

        return $activity->slug;
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


    public function fetchHomePageActivities()
    {
        $activities = Activity::latest()->limit(9)->get();
        return view('home', [
            'activities' => $activities,
            'activitiesCount' => Activity::all()->count(),
            'sukarelawanCount' => SukarelawanActivityDetail::all()->count(),
            'fasilitatorCount' => Fasilitator::all()->count(),
        ]);
    }


    public function like(Activity $activity)
    {
        $sukarelawan = auth()->user()->sukarelawan;
        $status = SukarelawanActivityStatus::where('name', 'Null')->first();


        $existingLike = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawan->id)
            ->where('activityId', $activity->id)
            ->first();

        if ($existingLike) {
            // If already liked, toggle isLiked
            $existingLike->update(['isLiked' => !$existingLike->isLiked]);
            $isLiked = !$existingLike->isLiked;
        } else {
            // If not liked, create a like
            SukarelawanActivityDetail::create([
                'id' => Generator::generateId(SukarelawanActivityDetail::class),
                'sukarelawanId' => $sukarelawan->id,
                'activityId' => $activity->id,
                'isLiked' => true,
                'sukarelawanActivityStatusId' => $status->id,
            ]);
            $isLiked = true;
        }

        $message = "Like action successful";

        return redirect()->route('activity.publicShow', ['activity' => $activity->slug]);
    }


    public function joinActivity(Activity $activity)
    {
        $sukarelawan = auth()->user()->sukarelawan;

        if ($sukarelawan) {
            $existingDetail = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawan->id)
                ->where('activityId', $activity->id)
                ->first();

            $terdaftarStatus = SukarelawanActivityStatus::where('name', 'Terdaftar')->first();

            if ($existingDetail) {
                $existingDetail->update(['sukarelawanActivityStatusId' => $terdaftarStatus->id]);
            } else {
                // If no row exists, create a new row
                SukarelawanActivityDetail::create([
                    'id' => Generator::generateId(SukarelawanActivityDetail::class),
                    'sukarelawanId' => $sukarelawan->id,
                    'activityId' => $activity->id,
                    'sukarelawanActivityStatusId' => $terdaftarStatus->id,
                    'isLiked' => true,
                ]);
            }

        } else {
            return redirect('/login');
        }
        return redirect()->route('activity.publicShow', ['activity' => $activity->slug]);

    }

    public function unjoinActivity(Activity $activity)
    {
        $sukarelawan = auth()->user()->sukarelawan;

        if ($sukarelawan) {
            $existingDetail = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawan->id)
                ->where('activityId', $activity->id)
                ->first();

            $cancelStatus = SukarelawanActivityStatus::where('name', 'Null')->first();

            if ($existingDetail) {
                $existingDetail->update(['sukarelawanActivityStatusId' => $cancelStatus->id]);
            }

        } else {
            return redirect('/login');
        }
        return redirect()->route('activity.publicShow', ['activity' => $activity->slug]);

    }

    public function takeAttendance(Activity $activity, $isWithinGatherRadius = false){
        //check if activity status is eligible [Terdaftar]
        $sukarelawan = auth()->user()->sukarelawan;
        $sukarelawanActivityDetail = SukarelawanActivityDetail::where(['sukarelawanId' => $sukarelawan->id, 'activityId' => $activity->id])->first();

        // dd($sukarelawanActivityDetail);

        if (!$sukarelawanActivityDetail) {
            return redirect()
                ->route('activity.publicShow', ['activity' => $activity->slug])
                ->with('error', 'Failed to Clock In, Status Invalid');
        }

        $sukarelawanActivityStatus = SukarelawanActivityStatus::find($sukarelawanActivityDetail->sukarelawanActivityStatusId);
        if (!$sukarelawanActivityStatus || $sukarelawanActivityStatus->name !== 'Terdaftar') {
            return redirect()
                ->route('activity.publicShow', ['activity' => $activity->slug])
                ->with('error', 'Failed to Clock In, Status Invalid');
        }


        //check if currDate === cleanUpDate
        $currDate = now()->toDateString();
        $cleanUpDate = $activity->cleanUpDate;
        if ($currDate !== $cleanUpDate) {
            return redirect()
                ->route('activity.publicShow', ['activity' => $activity->slug])
                ->with('error', 'Failed to Clock In, Invalid Date');
        }

        //check if the time is within the time range, startTime +- 30min
        $startTime = Carbon::parse($activity->startTime);
        $currentTime = now();

        if ($currentTime->greaterThanOrEqualTo($startTime->subMinutes(30)) && $currentTime->lessThanOrEqualTo($startTime->addMinutes(30))) {
        } else {
            return redirect()
                ->route('activity.publicShow', ['activity' => $activity->slug])
                ->with('error', 'Failed to Clock In, Invalid Time');
        }

        // G JADI CHECK VIA LOCATION, karena harus pakai GOOGLE TOKEN

        // IF PASSED ALL LOGIC THEN UPDATE TO CLOCKEDIN
        $newStatus = SukarelawanActivityStatus::where("name", "ClockedIn")->first();
        if($newStatus){
            $sukarelawanActivityDetail->sukarelawanActivityStatusId = $newStatus->id;
            $sukarelawanActivityDetail->save();
        }

        return redirect()->route("activity.publicShow", ['activity' => $activity->slug]);
    }

}
