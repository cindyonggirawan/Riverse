<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VerificationStatus extends Model
{
    use HasFactory;

    protected $table = 'verification_statuses';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    /**
     * Get all of the sukarelawans for the VerificationStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sukarelawans(): HasMany
    {
        return $this->hasMany(Sukarelawan::class, 'verificationStatusId', 'id');
    }

    /**
     * Get all of the fasilitators for the VerificationStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fasilitators(): HasMany
    {
        return $this->hasMany(Fasilitator::class, 'verificationStatusId', 'id');
    }
}
