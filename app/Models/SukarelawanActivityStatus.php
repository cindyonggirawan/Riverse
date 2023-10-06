<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SukarelawanActivityStatus extends Model
{
    use HasFactory;

    protected $table = 'sukarelawan_activity_statuses';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function sukarelawanActivityDetails(): HasMany
    {
        return $this->hasMany(SukarelawanActivityDetail::class, 'sukarelawanActivityStatusId', 'id');
    }
}
