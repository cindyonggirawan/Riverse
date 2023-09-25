<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use HasFactory;

    protected $table = 'levels';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    /**
     * Get all of the sukarelawans for the Level
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sukarelawans(): HasMany
    {
        return $this->hasMany(Sukarelawan::class, 'levelId', 'id');
    }

    /**
     * Get all of the benefits for the Level
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function benefits(): HasMany
    {
        return $this->hasMany(Benefit::class, 'levelId', 'id');
    }
}
