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
    public function publicIndex(Request $request)
    {
        $query = Activity::query();
        // filter by activityStatusId
        $query->whereHas('activityStatus', function ($subQuery) {
            $subQuery->where('name', 'Pendaftaran Sedang Dibuka');
        });

        //filter by verificationStatusId
        $query->whereHas('verificationStatus', function ($subQuery) {
            $subQuery->where('name', 'Sudah Diverifikasi');
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
            } elseif ($sortBy === 'dateFarthest') {
                $query->orderByDesc('cleanUpDate');
            } elseif ($sortBy === 'mostLikes') {
                $query->withCount(['sukarelawan_activity_details as like_count' => function ($query) {
                    $query->where('isLiked', true);
                }])->orderByDesc('like_count');
            } elseif ($sortBy === 'leastLikes') {
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

    public function publicCreate(Request $request, $step = 1)
    {
        if (auth()->user()->fasilitator->verificationStatus->name !== "Sudah Diverifikasi") {
            return redirect('/activities');
        } // validate if this is the correct fasilitator
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

        $bannerImageFile = $request->file('picture');

        // Check if a picture has been uploaded
        if ($bannerImageFile) {
            $hasNewImage = true;
            $previousImage = Session::get('step1Data.picture');
            if ($previousImage) {
                Storage::delete('/images' . '/' . $previousImage);
            }
            $fileName = uniqid() . '.' . $bannerImageFile->getClientOriginalExtension();
            $bannerImageUrl = $bannerImageFile->storeAs('/images/Activity/bannerImages', $fileName);
            $bannerImageUrl = 'Activity/bannerImages/' . $fileName;
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

    private function handleCreateStep3()
    {
        $step1Data = Session::get('step1Data');
        $step2Data = Session::get('step2Data');
        $combinedData = array_merge($step1Data, $step2Data);
        $request = new Request($combinedData);

        $id = Generator::generateId(Activity::class);

        $oldFileUrl = $request->picture;
        $directoryPath = pathinfo($oldFileUrl, PATHINFO_DIRNAME);
        $fileExtension = pathinfo($oldFileUrl, PATHINFO_EXTENSION);

        $newFileName = $id . '.' . $fileExtension;
        $newFileUrl =  $directoryPath . '/' . $newFileName;

        Storage::move('/images' . '/' . $oldFileUrl, '/images' . '/' . $newFileUrl);

        $slug = Generator::generateSlug(Activity::class, $request->name);

        $newActivity = Activity::create([
            'id' => $id,
            'verificationStatusId' => VerificationStatus::where('name', 'Menunggu Verifikasi')->first()->id,
            'riverId' => River::where('name', 'Sungai Ciliwung')->first()->id,
            'fasilitatorId' => Auth::user()->id,
            'activityStatusId' => ActivityStatus::where('name', 'Pendaftaran Sedang Dibuka')->first()->id,
            'name' => ucwords($request->name),
            'description' => $request->description,
            'registrationDeadlineDate' => date('Y-m-d', strtotime(str_replace('/', '-', $request->registrationDeadlineDate))),
            'cleanUpDate' => date('Y-m-d', strtotime(str_replace('/', '-', $request->cleanUpDate))),
            'startTime' => date('H:i:s', strtotime($request->startTime)),
            'endTime' => date('H:i:s', strtotime($request->endTime)),
            'gatheringPointUrl' => $request->gatheringPointUrl,
            'sukarelawanJobName' => $request->sukarelawanJobName,
            'sukarelawanJobDetail' => $request->sukarelawanJobDetail,
            'sukarelawanCriteria' => $request->sukarelawanCriteria,
            'minimumNumOfSukarelawan' => $request->minimumNumOfSukarelawan,
            'sukarelawanEquipment' => $request->sukarelawanEquipment,
            'groupChatUrl' => $request->groupChatUrl,
            'bannerImageUrl' => $newFileUrl,
            'slug' => $slug
        ]);

        // Optionally, you can clear the session data for steps 1 and 2 if needed
        Session::forget('step1Data');
        Session::forget('step2Data');

        return $newActivity;
    }

    public function publicDestroy(Activity $activity)
    {
        if ($activity->fasilitator->id != auth()->user()->fasilitator->id) {
            return redirect('/');
        } // validate if this is the correct fasilitator

        if ($activity->verificationStatus->name != "Sudah Diverifikasi") {
            if ($activity->bannerImageUrl) {
                Storage::delete($activity->bannerImageUrl);
            }
            $activity->delete();
            return redirect('fasilitators/' .
                auth()->user()->fasilitator->slug
                . '/manage')->with('success', 'Activity destruction successful!');
        } //


        return redirect('/');
    }

    public function publicEdit(Activity $activity, $step = 1)
    {
        // $this->authorize('update', $activity);
        if (Auth::check() && auth()->user()->fasilitator !== null && $activity->fasilitatorId == auth()->user()->fasilitator->id) {
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

        if ($sukarelawan) {
            $existingLike = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawan->id)
                ->where('activityId', $activity->id)
                ->first();

            $nullStatus = SukarelawanActivityStatus::where('name', 'Null')->first();

            if ($existingLike) {
                // If sukarelawan has interacted with the activity, toggle isLiked
                $existingLike->update([
                    'isLiked' => !$existingLike->isLiked
                ]);
            } else {
                // If not, create a like relationship by connecting sukarelawan and activity
                SukarelawanActivityDetail::create([
                    'id' => Generator::generateId(SukarelawanActivityDetail::class),
                    'sukarelawanId' => $sukarelawan->id,
                    'activityId' => $activity->id,
                    'sukarelawanActivityStatusId' => $nullStatus->id,
                    'isLiked' => true
                ]);
            }
        } else {
            return redirect('/login');
        }

        return redirect()->route('activity.publicShow', ['activity' => $activity->slug]);
    }


    public function joinActivity(Activity $activity)
    {
        $sukarelawan = auth()->user()->sukarelawan;

        $today = Carbon::now();
        $registrationDate = Carbon::parse($activity->registrationDeadlineDate);
        $isPassedMaxRegistrationDate = false;

        if ($today->gt($registrationDate)) {
            $isPassedMaxRegistrationDate = true;
        }

        if ($sukarelawan) {
            if ($isPassedMaxRegistrationDate) {
                return redirect()->route('activity.publicShow', ['activity' => $activity->slug])
                    ->with('error', 'Failed to Join, Sukarelawan has passed the maximum registration date');
            } else if ($sukarelawan->verificationStatus->name !== 'Sudah Diverifikasi') {
                return redirect()->route('activity.publicShow', ['activity' => $activity->slug])
                    ->with('error', 'Failed to Join, Sukarelawan has not been verified');
            }

            $existingDetail = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawan->id)
                ->where('activityId', $activity->id)
                ->first();

            $terdaftarStatus = SukarelawanActivityStatus::where('name', 'Terdaftar')->first();

            if ($existingDetail) {
                // If sukarelawan has interacted with the activity, change the status from null to terdaftar
                $existingDetail->update([
                    'sukarelawanActivityStatusId' => $terdaftarStatus->id
                ]);
            } else {
                // If not, create a join relationship by connecting sukarelawan and activity
                SukarelawanActivityDetail::create([
                    'id' => Generator::generateId(SukarelawanActivityDetail::class),
                    'sukarelawanId' => $sukarelawan->id,
                    'activityId' => $activity->id,
                    'sukarelawanActivityStatusId' => $terdaftarStatus->id,
                    'isLiked' => false
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

        $today = Carbon::now();
        $registrationDate = Carbon::parse($activity->registrationDeadlineDate);
        $isPassedMaxRegistrationDate = false;

        if ($today->gt($registrationDate)) {
            $isPassedMaxRegistrationDate = true;
        }

        if ($sukarelawan) {
            if ($isPassedMaxRegistrationDate) {
                return redirect()->route('activity.publicShow', ['activity' => $activity->slug])
                    ->with('error', 'Failed to Join, Sukarelawan has passed the maximum registration date');
            } else if ($sukarelawan->verificationStatus->name !== 'Sudah Diverifikasi') {
                return redirect()->route('activity.publicShow', ['activity' => $activity->slug])
                    ->with('error', 'Failed to Join, Sukarelawan has not been verified');
            }

            $existingDetail = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawan->id)
                ->where('activityId', $activity->id)
                ->first();

            $nullStatus = SukarelawanActivityStatus::where('name', 'Null')->first();

            // Sukarelawan definitely have interacted with the activity, change the status from null to terdaftar
            if ($existingDetail) {
                $existingDetail->update([
                    'sukarelawanActivityStatusId' => $nullStatus->id
                ]);
            } else {
                return redirect()
                    ->route('activity.publicShow', ['activity' => $activity->slug])
                    ->with('error', 'Failed to Unjoin, Sukarelawan has not joined');
            }
        } else {
            return redirect('/login');
        }

        return redirect()->route('activity.publicShow', ['activity' => $activity->slug]);
    }

    public function takeAttendance(Activity $activity)
    {
        $sukarelawan = auth()->user()->sukarelawan;

        if ($sukarelawan) {
            if ($sukarelawan->verificationStatus->name !== 'Sudah Diverifikasi') {
                return redirect()->route('activity.publicShow', ['activity' => $activity->slug])
                    ->with('error', 'Failed to Join, Sukarelawan has not been verified');
            }

            $sukarelawanActivityDetail = SukarelawanActivityDetail::where('sukarelawanId', $sukarelawan->id)
                ->where('activityId', $activity->id)
                ->first();

            // If sukarelawan has not joined the activity
            if (!$sukarelawanActivityDetail) {
                return redirect()
                    ->route('activity.publicShow', ['activity' => $activity->slug])
                    ->with('error', 'Failed to Clock In, Sukarelawan has not joined');
            }

            $sukarelawanActivityStatus = SukarelawanActivityStatus::find($sukarelawanActivityDetail->sukarelawanActivityStatusId);

            // If sukarelawan has joined the activity but the status is not registered
            if (!$sukarelawanActivityStatus || $sukarelawanActivityStatus->name !== 'Terdaftar') {
                return redirect()
                    ->route('activity.publicShow', ['activity' => $activity->slug])
                    ->with('error', 'Failed to Clock In, Sukarelawan status is not registered');
            }

            // If sukarelawan has joined the activity but the clock in time is invalid
            if (!$activity->isEligibleForClockIn()) {
                return redirect()
                    ->route('activity.publicShow', ['activity' => $activity->slug])
                    ->with('error', 'Failed to Clock In, Sukarelawan clock in time is invalid');
            }

            // If not, change the status from terdaftar to clockedin
            $clockedInStatus = SukarelawanActivityStatus::where("name", "ClockedIn")->first();
            $sukarelawanActivityDetail->update([
                'sukarelawanActivityStatusId' => $clockedInStatus->id
            ]);
        } else {
            return redirect('/login');
        }

        return redirect()->route("activity.publicShow", ['activity' => $activity->slug]);
    }
}
