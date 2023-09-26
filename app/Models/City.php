<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $with = ['province'];

    /**
     * Get the province that owns the City
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'provinceId', 'id');
    }

    /**
     * Get all of the rivers for the City
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rivers(): HasMany
    {
        return $this->hasMany(River::class, 'cityId', 'id');
    }
}
