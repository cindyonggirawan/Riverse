<?php

namespace App\Http\Controllers;

use App\Models\River;
use App\Models\Activity;
use App\Models\Generator;
use Illuminate\Http\Request;
use App\Models\ActivityStatus;
use App\Models\VerificationStatus;
use Illuminate\Support\Facades\Auth;

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

    public function show(Activity $activity)
    {
        return view('admin.Tables.Activity.activity', [
            'title' => 'Activity',
            'activity' => $activity
        ]);
    }

    public function create()
    {
        return view('admin.Tables.Activity.create', [
            'title' => 'Create Activity'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
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
            'sukarelawanJobName' => 'required|string|max:255',
            'sukarelawanJobDetail' => 'required|string|max:255',
            'sukarelawanCriteria' => 'required|string|max:255',
            'minimumNumOfSukarelawan' => 'required|integer|min:1|max:999',
            'sukarelawanEquipment' => 'required|string|max:255',
            'groupChatUrl' => [
                'required',
                'string',
                'regex:#^(https?://)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$#',
            ]
        ]);

        Activity::create([
            'id' => Generator::generateId(Activity::class),
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
            'sukarelawanJobName' => $request->sukarelawanJobName,
            'sukarelawanJobDetail' => $request->sukarelawanJobDetail,
            'sukarelawanCriteria' => $request->sukarelawanCriteria,
            'minimumNumOfSukarelawan' => $request->minimumNumOfSukarelawan,
            'sukarelawanEquipment' => $request->sukarelawanEquipment,
            'groupChatUrl' => $request->groupChatUrl,
            'slug' => Generator::generateSlug(Activity::class, $request->name)
        ]);

        return redirect('/activities')->with('success', 'Activity creation successful!');
    }
}
