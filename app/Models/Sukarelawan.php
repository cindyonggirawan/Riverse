<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Sukarelawan as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Sukarelawan extends Model
{
    use HasFactory;

    protected $table = 'sukarelawans';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $with = ['user', 'verificationStatus', 'level'];

    /**
     * getExperiencePointAttribute method to retrieve the value
     * when accessing $sukarelawan->experiencePoint
     */
    public function getExperiencePointAttribute()
    {
        $experiencePoint = 0;

        return $experiencePoint;
    }

    /**
     * Get the user that owns the Sukarelawan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    /**
     * Get the verificationStatus that owns the Sukarelawan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function verificationStatus(): BelongsTo
    {
        return $this->belongsTo(VerificationStatus::class, 'verificationStatusId', 'id');
    }

    /**
     * Get the level that owns the Sukarelawan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'levelId', 'id');
    }

    public function sukarelawan_activity_details(): HasMany
    {
        return $this->hasMany(SukarelawanActivityDetail::class, 'sukarelawanId', 'id');
    }

    public function experience_histories()
    {
        return $this->hasMany(ExperienceHistory::class, 'sukarelawanId', 'id');
    }
}
