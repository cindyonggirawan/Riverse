<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $with = ['verificationStatus', 'river', 'fasilitator', 'activityStatus'];

    /**
     * Get the verificationStatus that owns the Activity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function verificationStatus(): BelongsTo
    {
        return $this->belongsTo(VerificationStatus::class, 'verificationStatusId', 'id');
    }

    /**
     * Get the river that owns the Activity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function river(): BelongsTo
    {
        return $this->belongsTo(River::class, 'riverId', 'id');
    }

    /**
     * Get the fasilitator that owns the Activity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fasilitator(): BelongsTo
    {
        return $this->belongsTo(Fasilitator::class, 'fasilitatorId', 'id');
    }

    /**
     * Get the activityStatus that owns the Activity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activityStatus(): BelongsTo
    {
        return $this->belongsTo(ActivityStatus::class, 'activityStatusId', 'id');
    }

    public function sukarelawan_activity_details(): HasMany
    {
        return $this->hasMany(SukarelawanActivityDetail::class, 'activityId', 'id');
    }

    public function likeCount()
    {
        return $this->sukarelawan_activity_details()->where('isLiked', true)->count();
    }

    public function joinedSukarelawanCount()
    {
        $count = $this->sukarelawan_activity_details()->whereHas('sukarelawanActivityStatus', function ($query){
            $query->where('name',  "Terdaftar");
        })
        ->count();
        return $count;
    }
    
    public function isEligibleForClockIn(){
        
        $sukarelawan = auth()->user()->sukarelawan;
        $activity = $this;
        
        
        $sukarelawanActivityDetail = SukarelawanActivityDetail::where(['sukarelawanId' => $sukarelawan->id, 'activityId' => $activity->id])->first();
        if (!$sukarelawanActivityDetail) {
            // vardump();
            return false;
        }
        
        $sukarelawanActivityStatus = SukarelawanActivityStatus::find($sukarelawanActivityDetail->sukarelawanActivityStatusId);
        if (!$sukarelawanActivityStatus || $sukarelawanActivityStatus->name !== 'Terdaftar') {
            // vardump();
            return false;
        }


        // //comment this out later:
        // return true;
        
        $currDate = now()->toDateString();
        $cleanUpDate = $activity->cleanUpDate;
        if ($currDate !== $cleanUpDate) {
            // vardump();
            return false;
        }

        $startTime = Carbon::parse($activity->startTime)->setTimezone('Asia/Jakarta');
        $currentTime = now()->setTimezone('Asia/Jakarta');
        
        $startTimeMinus30 = $startTime->copy()->subMinutes(30);
        $startTimePlus30 = $startTime->copy()->addMinutes(30);
        
        if ($currentTime->greaterThanOrEqualTo($startTimeMinus30) && $currentTime->lessThanOrEqualTo($startTimePlus30)) {
            // Your logic when the current time is within the 30-minute range of the start time
        } else {
            // dd([$currentTime, $startTimeMinus30, $startTimePlus30]);
            return false;
        }
        

        //TODO: check location

        //PASSED ALL CHECK
        return true;
    }

    public function isEligibleForClockOut(){
        return true;
    }
}
