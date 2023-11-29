<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
            return false;
        }
        
        $sukarelawanActivityStatus = SukarelawanActivityStatus::find($sukarelawanActivityDetail->sukarelawanActivityStatusId);
        if (!$sukarelawanActivityStatus || $sukarelawanActivityStatus->name !== 'Terdaftar') {
            return false;
        }

        $currDate = now()->toDateString();
        $cleanUpDate = $activity->cleanUpDate;
        if ($currDate !== $cleanUpDate) {
            return false;
        }

        $startTime = Carbon::parse($activity->startTime);
        $currentTime = now();

        if ($currentTime->greaterThanOrEqualTo($startTime->subMinutes(30)) && $currentTime->lessThanOrEqualTo($startTime->addMinutes(30))) {
        } else {
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
