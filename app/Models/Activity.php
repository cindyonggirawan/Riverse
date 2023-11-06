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
        return $this->hasMany(SukarelawanActivityDetail::class, 'sukarelawanId', 'id');
    }

    public function getLikes()
    {
        return $this->sukarelawan_activity_details->where('isLiked', true)->count();
    }

    public function getJoinedSukarelawanAmount()
    {
        return 0;
    }

    public function scopeSortByLikes($query, $order = 'desc')
    {
        return $query->select('activities.*')
            ->withCount(['sukarelawanActivityDetails as likes' => function ($query) {
                $query->where('isLiked', true);
            }])
            ->orderBy('likes', $order);
    }
}
