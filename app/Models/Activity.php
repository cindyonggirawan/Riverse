<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
