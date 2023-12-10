<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Fasilitator extends Model
{
    use HasFactory;

    protected $table = 'fasilitators';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $with = ['user', 'verificationStatus', 'fasilitatorType'];

    /**
     * Get the user that owns the Fasilitator
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    /**
     * Get the verificationStatus that owns the Fasilitator
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function verificationStatus(): BelongsTo
    {
        return $this->belongsTo(VerificationStatus::class, 'verificationStatusId', 'id');
    }

    /**
     * Get the fasilitatorType that owns the Fasilitator
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fasilitatorType(): BelongsTo
    {
        return $this->belongsTo(FasilitatorType::class, 'fasilitatorTypeId', 'id');
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'id', 'fasilitatorId');
    }


    public function activities(): HasMany{
        return $this->hasMany(Activity::class, 'fasilitatorId', 'id');
    }
}
