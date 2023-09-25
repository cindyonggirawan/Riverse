<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FasilitatorType extends Model
{
    use HasFactory;

    protected $table = 'fasilitator_types';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    /**
     * Get all of the fasilitators for the FasilitatorType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fasilitators(): HasMany
    {
        return $this->hasMany(Fasilitator::class, 'fasilitatorTypeId', 'id');
    }
}
